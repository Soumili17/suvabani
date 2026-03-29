<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Barryvdh\DomPDF\Facade\Pdf;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Errors\SignatureVerificationError;
class DonationController extends Controller
{

    // Donation Form
    public function create()
    {
        return view('frontend.donate');
    }


    // Store Donation

    public function store(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
        } catch (SignatureVerificationError $e) {
            return back()->withErrors("Payment verification failed");
        }
        // ✅ CONDITIONAL VALIDATION

        $rules = [
            'donor_phone' => 'required',
            'amount' => 'required|numeric|min:1',
            'need_80g' => 'required',
            'razorpay_payment_id' => 'required'
        ];

        if ($request->need_80g === "Yes") {

            $rules['donor_name'] = 'required';
            $rules['donor_email'] = 'required|email';
            $rules['donor_address'] = 'required';
            $rules['donor_city'] = 'required';
            $rules['donor_state'] = 'required';
            $rules['donor_pincode'] = 'required';
            $rules['donor_pan'] = 'required';

        } else {

            $rules['donor_email'] = 'nullable|email';

        }

        $request->validate($rules);

        DB::beginTransaction();

        try {

            // ✅ FIND OR CREATE DONOR (PHONE BASED)

            $donor = DB::table('donors')
                ->where('phone', $request->donor_phone)
                ->first();

            if (!$donor) {

                $donorId = DB::table('donors')->insertGetId([
                    'name' => $request->donor_name ?? 'Anonymous',
                    'email' => $request->donor_email,
                    'phone' => $request->donor_phone,
                    'address' => $request->donor_address,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            } else {

                $donorId = $donor->id;

            }

            // ✅ CREATE DONATION

            $donationId = DB::table('donations')->insertGetId([

                'donor_id' => $donorId,
                'amount' => $request->amount,
                'need_80g' => $request->need_80g === "Yes" ? 1 : 0,
                'pan_number' => $request->donor_pan,
                'donation_purpose' => $request->donation_purpose,
                'donation_date' => now(),
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'payment_status' => 'Paid',
                'payment_method' => 'Razorpay',
                'receipt_number' => 'SVB-' . date('Y') . '-' . rand(1000,9999),
                'created_at' => now(),
                'updated_at' => now()

            ]);

            DB::commit();

            // ✅ FETCH DATA FOR PDF

            $donation = DB::table('donations')
                ->join('donors','donors.id','=','donations.donor_id')
                ->where('donations.id',$donationId)
                ->select(
                    'donations.*',
                    'donors.name',
                    'donors.email',
                    'donors.phone',
                    'donors.address'
                )
                ->first();

            // ✅ GENERATE INVOICE PDF

            $pdf = Pdf::loadView('frontend.invoice_pdf', compact('donation'));

            return $pdf->download('invoice_'.$donation->receipt_number.'.pdf');

        } catch (\Exception $e) {

            DB::rollback();

            return back()->withErrors($e->getMessage());

        }
    }


    public function createOrder(Request $request)
    {

        $amount = $request->amount;

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => 'donation_'.time(),
            'amount' => $amount * 100,
            'currency' => 'INR'
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $order['amount']
        ]);
    }



    // Admin Donor List + Search
    public function adminIndex(Request $request)
    {

        $query = DB::table('donations')
                ->join('donors','donors.id','=','donations.donor_id')
                ->select(
                    'donations.*',
                    'donors.name',
                    'donors.email',
                    'donors.phone',
                    'donors.address'
                );

        if ($request->search) {

            $query->where(function($q) use ($request){
                $q->where('donors.name','like','%'.$request->search.'%')
                ->orWhere('donors.email','like','%'.$request->search.'%')
                ->orWhere('donors.phone','like','%'.$request->search.'%');
            });

        }

        $donors = $query->orderBy('donations.id','desc')->paginate(15);

        return view('layouts.donors_show', compact('donors'));

    }



    // View Donor
    public function viewDonor($id)
    {
        $donor = Donation::findOrFail($id);

        return view('layouts.donor_view',compact('donor'));
    }



    // Edit Donor
    public function editDonor($id)
    {
        $donor = Donation::findOrFail($id);

        return view('layouts.donor_edit',compact('donor'));
    }



    // Update Donor
    public function updateDonor(Request $request,$id)
    {

        $donor = Donation::findOrFail($id);

        $donor->update($request->all());

        return redirect()->route('dashboard.donors')
        ->with('success','Donor updated successfully');

    }



    // Delete Donor
    public function deleteDonor($id)
    {

        $donor = Donation::findOrFail($id);

        $donor->delete();

        return redirect()->route('dashboard.donors')
        ->with('success','Donor deleted successfully');

    }



    // Download Donation Receipt
    public function downloadReceipt($id)
    {

        $donor = Donation::findOrFail($id);

        $pdf = Pdf::loadView('frontend.receipt_pdf',compact('donor'));

        return $pdf->download('donation_receipt_'.$donor->id.'.pdf');

    }



    // Show 80G Form Page
  


    public function show80GForm()
    {
        return view('frontend.search_80g');
    }
    public function search80G(Request $request)
    {

        $request->validate([
        'mobile'=>'required'
        ]);

        $donations = DB::table('donations')
            ->join('donors','donors.id','=','donations.donor_id')
            ->where('donors.phone',$request->mobile)
            ->where('donations.need_80g',1)
            ->select(
                'donations.id',
                'donations.amount',
                'donations.receipt_number',
                'donations.created_at',
                'donors.name'
            )
            ->get();

        if($donations->isEmpty()){
        return back()->withErrors([
        'mobile'=>'No 80G donations found'
        ]);
        }

        return view('frontend.80g_results',compact('donations'));

    }
    
    //download 80G
    public function download80G($id)
{

    $donation = DB::table('donations')
        ->join('donors','donors.id','=','donations.donor_id')
        ->where('donations.id',$id)
        ->select(
            'donations.*',
            'donors.name',
            'donors.phone',
            'donors.email',
            'donors.address'
        )
        ->first();

    if(!$donation){
        abort(404);
    }

    $form = (object)[
        'pan' => $donation->pan_number ?? '',
        'name' => 'SUVABANI FOUNDATION',
        'activity' => $donation->donation_purpose ?? 'Charitable',
        'building' => $donation->address ?? '',
        'village' => '',
        'post' => '',
        'locality' => '',
        'district' => '',
        'state' => 'West Bengal',
        'country' => 'India',
        'pincode' => '',
        'din' => 'DIN-'.$donation->id,
        'application_no' => $donation->receipt_number,
        'registration_no' => '80G-REG-001',
        'section' => '80G',
        'approval_date' => date('d-m-Y', strtotime($donation->created_at)),
        'assessment_year' => 'AY '.date('Y').'-'.(date('Y')+1),
        'authority' => 'Principal Commissioner of Income Tax',

        'order_a' => 'Donation received from '.$donation->name,
        'order_b' => 'Amount donated ₹'.$donation->amount,
        'order_c' => 'Receipt number '.$donation->receipt_number,

        'condition_a' => 'Used for charitable purposes',
        'condition_b' => 'Eligible under section 80G',
        'condition_c' => 'Auto generated receipt',
        'condition_d' => 'Retain for tax filing'
    ];

    $pdf = Pdf::loadView('frontend.form.from10AC', [
        'form' => $form,
        'donation' => $donation
    ]);

    return $pdf->download('80G_'.$donation->receipt_number.'.pdf');
}
}