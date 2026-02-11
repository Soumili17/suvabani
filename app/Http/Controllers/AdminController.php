<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Membership; // if you have a Membership model
use App\Models\Invoice;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Summary counts
        $totalDonations = Donation::sum('amount');
        $totalMemberships = Membership::sum('paid_amount');

        // Latest donations & memberships
        $recentDonations = Donation::with('donor')->latest()->take(5)->get();
        $recentMemberships = Membership::latest()->take(5)->get();

        // Latest invoices
        $recentInvoices = Invoice::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalDonations',
            'totalMemberships',
            'recentDonations',
            'recentMemberships',
            'recentInvoices'
        ));
    }
}

