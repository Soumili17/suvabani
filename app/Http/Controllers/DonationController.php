<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Barryvdh\DomPDF\Facade\Pdf;

class DonationController extends Controller
{
    // Show form
    public function create()
{
    return view('frontend.donate'); 
}


    // Store donation
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

        if ($request->need_80g === 'Yes' && empty($request->donor_pan)) {
            return back()->withErrors([
                'donor_pan' => 'PAN is required for 80G receipt'
            ]);
        }

        Donation::create([

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

            'receipt_number' => 'SVB-'.date('Y').'-'.rand(1000,9999)
        ]);

        return back()->with('success','Donation Successful!');
    }

    public function adminIndex(Request $request)
    {
        $query = Donation::query();

        // Filter by payment status
        if ($request->status) {
            $query->where('payment_status', $request->status);
        }

        // Filter by 80G
        if ($request->need_80g) {
            $query->where('need_80g', $request->need_80g == 1 ? 1 : 0);
        }

        $donations = $query->latest()->paginate(15);

        // Summary data
        $totalAmount = Donation::where('payment_status', 'Paid')->sum('amount');
        $totalDonations = Donation::where('payment_status', 'Paid')->count();
        $total80G = Donation::where('need_80g', 1)->count();
        $pendingCount = Donation::where('payment_status', 'Pending')->count();

        return view('admin.donations.index', compact(
            'donations',
            'totalAmount',
            'totalDonations',
            'total80G',
            'pendingCount'
        ));
    }



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

        'section' => '12 - Sub-clause (A) of clause (iv) of first proviso to sub-section (5) of section 80G',

        'approval_date' => '10-07-2025',

        'assessment_year' => 'From AY 2026-27 to AY 2028-2029',

        'order_a' => 'After considering the application of the applicant and the material available on record, the applicant is hereby granted provisional approval.',

        'order_b' => 'The taxability of the income of the applicant will be considered separately under the Income Tax Act.',

        'order_c' => 'The approval may be withdrawn if activities are not genuine.',

        'condition_a' => 'Registration under section 12AB has not been cancelled.',
        'condition_b' => 'Form 10A information is correct.',
        'condition_c' => 'Institution must apply within 6 months.',
        'condition_d' => 'Registration not cancelled for non-compliance.',

        'authority' => 'Principal Commissioner of Income Tax'

        ];

        return view('frontend.form10ac', compact('form'));

    }

    // Route::post('/download-form10ac', [DonationController::class,'downloadForm10AC'])->name('form10ac.download');
    
//     <form method="POST" action="{{ route('form10ac.download') }}">
// @csrf

// <label>Enter Mobile Number</label>
// <input type="text" name="mobile" required>

// <button type="submit">Download Form 10AC</button>

// </form>
    
    public function downloadForm10AC(Request $request)
    {

        $request->validate([
            'mobile' => 'required'
        ]);

        $donation = Donation::where('donor_phone', $request->mobile)->first();

        if (!$donation) {
            return back()->withErrors([
                'mobile' => 'No donation found for this mobile number'
            ]);
        }

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

            'section' => '12 - Sub-clause (A) of clause (iv) of first proviso to sub-section (5) of section 80G',

            'approval_date' => '10-07-2025',

            'assessment_year' => 'From AY 2026-27 to AY 2028-2029',

            'authority' => 'Principal Commissioner of Income Tax'
        ];

        $pdf = Pdf::loadView('frontend.form10ac', compact('form'));

        return $pdf->download('form10ac-certificate.pdf');
    }
}

