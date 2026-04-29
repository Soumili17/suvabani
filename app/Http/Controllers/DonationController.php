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
    public function validateForm(Request $request)
    {
        $rules = [
            'donor_phone' => 'required',
            'amount' => 'required|numeric|min:1',
            'need_80g' => 'required',
        ];

        if ($request->need_80g === "Yes") {
            $rules['donor_name'] = 'required';
            $rules['donor_email'] = 'required|email';
            $rules['donor_address'] = 'required';
            $rules['donor_city'] = 'required';
            $rules['donor_state'] = 'required';
            $rules['donor_pincode'] = 'required';
            $rules['donor_pan'] = 'required';
        }

        $request->validate($rules);

        return response()->json(['status' => true]);
    }

    public function store(Request $request)
    {
        // =========================
        // STEP 1: VALIDATION FIRST
        // =========================
        $rules = [
            'donor_phone' => 'required',
            'amount' => 'required|numeric|min:1',
            'need_80g' => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required'
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


        // =========================
        // STEP 2: VERIFY PAYMENT
        // =========================
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


        // =========================
        // STEP 3: SAVE DATA
        // =========================
        DB::beginTransaction();

        try {

            // 🔹 Insert donation directly into donations table
            $donationId = DB::table('donations')->insertGetId([
                'donor_name' => $request->donor_name ?? 'Anonymous',
                'donor_email' => $request->donor_email ?? '',
                'donor_phone' => $request->donor_phone,
                'donor_address' => $request->donor_address ?? '',
                'donor_city' => $request->donor_city ?? '',
                'donor_state' => $request->donor_state ?? '',
                'donor_pincode' => $request->donor_pincode ?? '',
                'amount' => $request->amount,
                'need_80g' => $request->need_80g === "Yes" ? 1 : 0,
                'donor_pan' => $request->donor_pan ?? '',
                'donation_purpose' => $request->donation_purpose ?? 'General Donation',
                'donation_date' => now(),
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'payment_status' => 'Paid',
                'receipt_number' => 'SVB-' . date('Y') . '-' . rand(1000,9999),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            // =========================
            // STEP 4: GENERATE PDF
            // =========================
            $donation = DB::table('donations')
                ->where('id',$donationId)
                ->select(
                    'donations.*',
                    'donor_name as name',
                    'donor_email as email',
                    'donor_phone as phone',
                    'donor_address as address'
                )
                ->first();

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
                ->select(
                    'donations.*',
                    'donor_name as name',
                    'donor_email as email',
                    'donor_phone as phone',
                    'donor_address as address'
                );

        if ($request->search) {

            $query->where(function($q) use ($request){
                $q->where('donor_name','like','%'.$request->search.'%')
                ->orWhere('donor_email','like','%'.$request->search.'%')
                ->orWhere('donor_phone','like','%'.$request->search.'%');
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

        $donationModel = Donation::findOrFail($id);
        $donationModel->name = $donationModel->donor_name;
        $donationModel->email = $donationModel->donor_email;
        $donationModel->phone = $donationModel->donor_phone;
        $donationModel->address = $donationModel->donor_address;

        $pdf = Pdf::loadView('frontend.receipt_pdf',[
            'donor' => $donationModel,
            'donation' => $donationModel
        ]);

        return $pdf->download('donation_receipt_'.$donationModel->receipt_number.'.pdf');

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
            ->where('donor_phone',$request->mobile)
            ->where('need_80g',1)
            ->select(
                'id',
                'amount',
                'receipt_number',
                'created_at',
                'donor_name as name'
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
            ->where('id',$id)
            ->select(
                'donations.*',
                'donor_name as name',
                'donor_phone as phone',
                'donor_email as email',
                'donor_address as address'
            )
            ->first();

        if(!$donation){
            abort(404);
        }

        $form = (object)[
            'pan' => $donation->donor_pan ?? '',
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