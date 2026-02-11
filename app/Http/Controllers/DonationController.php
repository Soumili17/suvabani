<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Barryvdh\DomPDF\Facade\Pdf; // Make sure DomPDF is imported

class DonationController extends Controller
{
    // Show donation form
    public function create()
    {
        return view('donation.form'); // your donation form blade
    }

    // Store donation
    public function store(Request $request)
    {
        $request->validate([
            'donor_name'=>'required|string|max:255',
            'donor_email'=>'required|email',
            'amount'=>'required|numeric|min:1',
        ]);

        $donation = Donation::create([
            'donor_name'=>$request->donor_name,
            'donor_email'=>$request->donor_email,
            'donor_phone'=>$request->donor_phone,
            'donor_address'=>$request->donor_address,
            'amount'=>$request->amount,
            'payment_method'=>$request->payment_method ?? 'Offline'
        ]);

        // Redirect to receipt download
        return redirect()->route('donate.receipt', $donation->id);
    }

    // ✅ Generate PDF receipt
    public function receipt($id)
    {
        $donation = Donation::findOrFail($id);

        $pdf = Pdf::loadView('donation.receipt_pdf', compact('donation'));

        return $pdf->download('Donation_Receipt_'.$donation->id.'.pdf');
    }
}
