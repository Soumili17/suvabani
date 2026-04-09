<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use Barryvdh\DomPDF\Facade\Pdf;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class MembershipController extends Controller
{
    public function createSubscription(Request $request)
    {
        $request->validate([
            'plan_id' => 'required'
        ]);
        // dd(config('services.razorpay'));
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {

            $subscription = $api->subscription->create([
                "plan_id" => $request->plan_id,
                "customer_notify" => 1,
                "total_count" => 120
            ]);

            return response()->json([
                'subscription_id' => $subscription['id']
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT APPLICATION
    |--------------------------------------------------------------------------
    */
    public function submit(Request $request)
    {
        $request->validate([
            'fullname'       => 'required|string|max:255',
            'parent_type'    => 'required',
            'parentname'     => 'required|string|max:255',
            'dob'            => 'required|date',
            'gender'         => 'required',
            'nationality'    => 'required|string',
            'occupation'     => 'required|string',
            'address'        => 'required|string',
            'phone'          => 'required|digits:10|unique:memberships,phone',
            'email'          => 'required|email|unique:memberships,email',
            'idproof'        => 'required',
            'idnumber'       => 'required|string',
            'photo'          => 'required|image|max:2048',
            'signature'      => 'required|image|max:1024',
            'idfile'         => 'required|file|max:4096',
            'membership_type'=> 'required',
            'membertype'     => 'required',
            'time'           => 'required',
            'declaration_date'=> 'required|date',
        ]);

        try {

            $member = Membership::create([

                // FILES
                'photo'     => $request->file('photo')->store('photos', 'public'),
                'signature' => $request->file('signature')->store('signatures', 'public'),
                'idfile'    => $request->file('idfile')->store('idproofs', 'public'),

                // BASIC INFO
                'fullname'    => $request->fullname,
                'parentname'  => $request->parentname,
                'dob'         => $request->dob,
                'gender'      => $request->gender,
                'nationality' => $request->nationality,
                'occupation'  => $request->occupation,
                'address'     => $request->address,
                'phone'       => $request->phone,
                'email'       => $request->email,

                // ID
                'idproof'  => $request->idproof,
                'idnumber' => $request->idnumber,

                // MEMBERSHIP
                'membership' => $request->membership_type,
                'membertype' => $request->membertype,
                'paidamount' => $request->membership_type === 'Paid'
                    ? $this->getPlanAmount($request->plan_id)
                    : null,

                // INTEREST (JSON)
                'interest'       => json_encode($request->interest ?? []),
                'interest_other' => $request->interest_other,

                // OTHER
                'experience' => $request->experience,
                'languages'  => $request->languages,
                'time'       => json_encode($request->time), // safe for JSON column
                'reason'     => $request->reason,
                'ref_name'   => $request->ref_name,
                'ref_mobile' => $request->ref_mobile,

                'declaration_date' => $request->declaration_date,

                // PAYMENT
                'razorpay_payment_id'      => $request->razorpay_payment_id,
                'razorpay_subscription_id' => $request->razorpay_subscription_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Membership submitted successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    private function getPlanAmount($planId)
    {
        $plans = [
            'plan_SVaR3a1MmEmmuJ' => 100,
            'plan_SRFl5J5teuIStk' => 200,
            'plan_SVaS0xDMQ4kpaE' => 500,
            'plan_SVaSS6ttAXZDx3' => 1000,
        ];

        return $plans[$planId] ?? 0;
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */
    public function approve($id)
    {
        $member = Membership::findOrFail($id);

        if ($member->approval_status === 'Approved') {
            return back()->withErrors('Already approved');
        }

        $member->membership_id =
            'SVF-' . date('Y') . '-' . str_pad($member->id, 4, '0', STR_PAD_LEFT);

        $member->approval_status = 'Approved';

        // ✅ ISSUE DATE = APPROVED DATE
        $member->approved_at = now();

        $member->save();

        return back()->with('success', 'Member approved');
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */
    public function reject($id)
    {
        $member = Membership::findOrFail($id);

        $member->approval_status = 'Rejected';
        $member->save();

        return back()->with('success', 'Member rejected');
    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL AUTOPAY
    |--------------------------------------------------------------------------
    */
    public function cancelSubscription($id)
    {
        $member = Membership::findOrFail($id);

        if (!$member->razorpay_subscription_id) {
            return back()->withErrors('No subscription found');
        }

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {

            $api->subscription
                ->fetch($member->razorpay_subscription_id)
                ->cancel();

            $member->subscription_status = 'Cancelled';
            $member->save();

            return back()->with('success', 'Autopay cancelled');

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH MEMBER
    |--------------------------------------------------------------------------
    */
    public function searchMember(Request $request)
    {
        $request->validate(['mobile' => 'required']);

        $member = Membership::where('phone', $request->mobile)
            ->where('approval_status', 'Approved')
            ->first();

        if (!$member) {
            return back()->withErrors(['mobile' => 'Member not found']);
        }

        return view('frontend.member_download', compact('member'));
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD CARD
    |--------------------------------------------------------------------------
    */
    public function downloadCard($id)
    {
        $member = Membership::findOrFail($id);

        if ($member->approval_status !== 'Approved') {
            abort(403);
        }

        $pdf = Pdf::loadView('frontend.form.member_card', compact('member'))
            ->setPaper([0, 0, 520, 400]);

        return $pdf->download('card_' . $member->membership_id . '.pdf');
    }


    /*
    |--------------------------------------------------------------------------
    | WEBHOOK
    |--------------------------------------------------------------------------
    */
    public function handleWebhook(Request $request)
    {
        $secret = config('services.razorpay.webhook_secret');

        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');

        try {
            (new Api(config('services.razorpay.key'), config('services.razorpay.secret')))
                ->utility
                ->verifyWebhookSignature($payload, $signature, $secret);
        } catch (\Exception $e) {
            Log::error('Webhook signature failed');
            return response()->json(['error' => 'Invalid'], 400);
        }

        $event = json_decode($payload, true);

        switch ($event['event']) {

            case 'payment.captured':
                $paymentId = $event['payload']['payment']['entity']['id'];

                Membership::where('razorpay_payment_id', $paymentId)
                    ->update(['payment_status' => 'Success']);
                break;

            case 'subscription.activated':
                $subId = $event['payload']['subscription']['entity']['id'];

                Membership::where('razorpay_subscription_id', $subId)
                    ->update(['subscription_status' => 'Active']);
                break;

            case 'subscription.cancelled':
                $subId = $event['payload']['subscription']['entity']['id'];

                Membership::where('razorpay_subscription_id', $subId)
                    ->update(['subscription_status' => 'Cancelled']);
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    //Admin
    public function adminIndex(Request $request)
    {
        $query = Membership::query();

        // 🔍 SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('membership_id', 'like', '%' . $request->search . '%');
            });
        }

        // 🎯 FILTER
        if ($request->status) {
            $query->where('approval_status', $request->status);
        }

        // 📄 PAGINATION
        $members = $query->latest()->paginate(15);

        return view('layouts.member_view', compact('members'));
    }
    public function view($id)
    {
        $member = Membership::findOrFail($id);

        return view('layouts.members_show', compact('member'));
    }
}