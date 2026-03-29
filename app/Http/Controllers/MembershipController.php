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
            'name' => 'required',
            'phone' => 'required|digits:10|unique:memberships,phone',
            'email' => 'required|email|unique:memberships,email',
            'photo' => 'required|image|max:2048',
            'signature' => 'required|image|max:1024',
            'idfile' => 'required|max:4096',
        ]);

        try {

            // 🔴 If Paid → VERIFY PAYMENT
            if ($request->membership_type === 'Paid') {

                if (!$request->razorpay_payment_id || !$request->razorpay_subscription_id) {
                    return response()->json(['error' => 'Payment not completed'], 400);
                }

                $api = new Api(
                    config('services.razorpay.key'),
                    config('services.razorpay.secret')
                );

                // 🔍 Verify payment
                $payment = $api->payment->fetch($request->razorpay_payment_id);

                if ($payment->status !== 'captured') {
                    return response()->json(['error' => 'Payment not verified'], 400);
                }
            }

            // ✅ STORE ONLY AFTER VERIFICATION
            $member = Membership::create([

                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,

                'membership_type' => $request->membership_type,

                // store plan instead of amount
                'plan_id' => $request->plan_id,

                // files
                'photo' => $request->file('photo')->store('photos', 'public'),
                'signature' => $request->file('signature')->store('signatures', 'public'),
                'idfile' => $request->file('idfile')->store('idproofs', 'public'),

                // payment
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_subscription_id' => $request->razorpay_subscription_id,

                'payment_status' => $request->membership_type === 'Paid' ? 'Success' : 'Free',
                'subscription_status' => $request->membership_type === 'Paid' ? 'Active' : 'N/A',

                'approval_status' => 'Pending'
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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