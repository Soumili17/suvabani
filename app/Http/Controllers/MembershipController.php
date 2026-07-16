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
            'dob'            => 'required|date',
            'gender'         => 'required',
            'blood_group'    => 'nullable|string|max:20',
            'nationality'    => 'nullable|string',
            'occupation'     => 'nullable|string',
            'address'        => 'nullable|string',
            'phone'          => 'required|digits:10|unique:memberships,phone',
            'email'          => 'required|email|unique:memberships,email',
            'idproof'        => 'nullable',
            'idnumber'       => 'nullable|string',
            'photo'          => 'required|image|max:2048',
            'signature'      => 'nullable|image|max:1024',
            'idfile'         => 'nullable|file|max:4096',
            'membership_type'=> 'required',
            'membertype'     => 'required',
            'time'           => 'nullable',
            'declaration_date'=> 'required|date',
        ]);

        try {

            $member = Membership::create([

                // FILES
                'photo'     => $request->file('photo') ? $request->file('photo')->store('photos', 'public') : null,
                'signature' => $request->file('signature') ? $request->file('signature')->store('signatures', 'public') : null,
                'idfile'    => $request->file('idfile') ? $request->file('idfile')->store('idproofs', 'public') : null,

                // BASIC INFO
                'fullname'    => trim($request->fullname),
                'dob'         => $request->dob,
                'gender'      => $request->gender,
                'blood_group' => $request->blood_group ? trim($request->blood_group) : null,
                'nationality' => $request->nationality ? trim($request->nationality) : null,
                'occupation'  => $request->occupation ? trim($request->occupation) : null,
                'address'     => $request->address ? trim($request->address) : null,
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
                'time'       => $request->time ? json_encode($request->time) : null,
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

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {

            if ($member->razorpay_subscription_id) {
                $api->subscription
                    ->fetch($member->razorpay_subscription_id)
                    ->cancel();
                $member->subscription_status = 'Cancelled';
            }

            $member->approval_status = 'Deactivated';
            $member->save();

            return back()->with('success', 'Member deactivated and autopay cancelled');

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT & UPDATE DOCUMENTS
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $member = Membership::findOrFail($id);
        return view('layouts.member_edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Membership::findOrFail($id);

        if ($request->hasFile('photo')) {
            $member->photo = $request->file('photo')->store('photos', 'public');
        }
        if ($request->hasFile('signature')) {
            $member->signature = $request->file('signature')->store('signatures', 'public');
        }
        if ($request->hasFile('idfile')) {
            $member->idfile = $request->file('idfile')->store('idproofs', 'public');
        }

        // Add additional field updates here if needed.

        $member->save();

        return redirect()->route('dashboard.members.view', $member->id)->with('success', 'Documents updated successfully');
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
            ->first(); // search regardless of approval status

        if (!$member) {
            return back()->withErrors(['mobile' => 'No membership found with this mobile number.']);
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
                $q->where('fullname', 'like', '%' . $request->search . '%')
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

    public function destroy($id)
    {
        $member = Membership::findOrFail($id);

        // Optional: you can delete uploaded files from storage here if needed
        // \Illuminate\Support\Facades\Storage::disk('public')->delete([$member->photo, $member->signature, $member->idfile]);

        $member->delete();

        return redirect()->route('dashboard.members')->with('success', 'Member deleted successfully');
    }
}