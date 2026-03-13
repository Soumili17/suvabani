<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'donor_address' => 'nullable|string',
            'donor_city' => 'nullable|string|max:100',
            'donor_state' => 'nullable|string|max:100',
            'donor_pincode' => 'nullable|string|max:10',
            'amount' => 'required|numeric|min:1',
            'need_80g' => 'required|in:Yes,No',
            'donor_pan' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'razorpay_payment_id' => 'required'
        ]);

        // PAN validation for 80G
        if ($request->need_80g === 'Yes' && empty($request->donor_pan)) {
            return back()->withErrors([
                'donor_pan' => 'PAN is required for 80G receipt'
            ]);
        }

        $donation = Donation::create([

            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donor_phone' => $request->donor_phone,
            'donor_address' => $request->donor_address,

            'donor_city' => $request->donor_city,
            'donor_state' => $request->donor_state,
            'donor_pincode' => $request->donor_pincode,

            'donation_purpose' => $request->donation_purpose,

            'amount' => $request->amount,
            'donation_date' => now(),

            'need_80g' => $request->need_80g === 'Yes',
            'donor_pan' => strtoupper($request->donor_pan),

            'razorpay_payment_id' => $request->razorpay_payment_id,
            'payment_status' => 'Paid',

            'receipt_number' => 'SVB-' . date('Y') . '-' . rand(1000,9999)

        ]);

        return redirect()->route('donation.receipt',$donation->id);
    }



    // Admin Donor List + Search
    public function adminIndex(Request $request)
    {

        $query = Donation::query();

        if ($request->search) {

            $query->where('donor_name','like','%'.$request->search.'%')
            ->orWhere('donor_email','like','%'.$request->search.'%')
            ->orWhere('donor_phone','like','%'.$request->search.'%');

        }

        $donors = $query->latest()->paginate(15);

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
    public function showForm10AC()
    {

        $form = (object)[
            'pan' => 'ABLTS3949L',
            'name' => 'SUVABANI FOUNDATION',
            'activity' => 'Charitable',
            'building' => 'RANIA',
            'village' => 'PRAVATPALLY',
            'post' => 'Boral S.O',
            'locality' => 'Sukantapally',
            'district' => 'South 24 Parganas',
            'state' => 'West Bengal',
            'country' => 'India',
            'pincode' => '700154',
            'din' => 'ABLTS3949LF2025101',
            'application_no' => '237126850030725',
            'registration_no' => 'ABLTS3949LF20251',
            'section' => '80G Approval',
            'approval_date' => '10-07-2025',
            'assessment_year' => 'AY 2026-27 to 2028-29',
            'authority' => 'Principal Commissioner of Income Tax'
        ];

        return view('frontend.form10ac',compact('form'));

    }



    // Download Form10AC by mobile
    public function downloadForm10AC(Request $request)
    {

        $request->validate([
            'mobile' => 'required'
        ]);

        $donation = Donation::where('donor_phone',$request->mobile)->first();

        if (!$donation) {

            return back()->withErrors([
                'mobile' => 'No donation found for this mobile number'
            ]);

        }

        $pdf = Pdf::loadView('frontend.form10ac');

        return $pdf->download('form10ac-certificate.pdf');

    }

}