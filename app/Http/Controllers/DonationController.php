<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

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
            'donor_email' => 'required|email',
            'amount' => 'required|numeric|min:1'
        ]);

        $donation = Donation::create([
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donor_phone' => $request->donor_phone,
            'donor_address' => $request->donor_address,
            'amount' => $request->amount,
            'payment_status' => 'Paid', // For now direct paid
            'receipt_number' => 'RCPT-' . rand(1000,9999)
        ]);

        return redirect()->back()->with('success', 'Donation Successful!');
    }
}

