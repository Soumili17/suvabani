@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="stat-box">
        <h3 class="text-lg font-semibold">Total Donations</h3>
        <p class="text-2xl mt-2">₹{{ number_format($totalDonations, 2) }}</p>
    </div>
    <div class="stat-box">
        <h3 class="text-lg font-semibold">Total Membership Payments</h3>
        <p class="text-2xl mt-2">₹{{ number_format($totalMemberships, 2) }}</p>
    </div>
</div>

<h2 class="text-xl font-bold mb-2">Recent Donations</h2>
<div class="overflow-x-auto mb-6">
    <table class="bg-white rounded shadow">
        <thead>
            <tr>
                <th>Donor</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Invoice</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentDonations as $donation)
            <tr class="hover:bg-gray-50">
                <td>{{ $donation->donor->name ?? 'N/A' }}</td>
                <td>₹{{ number_format($donation->amount, 2) }}</td>
                <td>{{ $donation->created_at->format('d-m-Y') }}</td>
                <td><a href="{{ route('invoice.download', $donation->id) }}" class="text-teal-600 hover:underline">Download</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<h2 class="text-xl font-bold mb-2">Recent Membership Payments</h2>
<div class="overflow-x-auto mb-6">
    <table class="bg-white rounded shadow">
        <thead>
            <tr>
                <th>Member</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Invoice</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentMemberships as $member)
            <tr class="hover:bg-gray-50">
                <td>{{ $member->name }}</td>
                <td>₹{{ number_format($member->paid_amount, 2) }}</td>
                <td>{{ $member->created_at->format('d-m-Y') }}</td>
                <td><a href="{{ route('invoice.download', $member->id) }}" class="text-teal-600 hover:underline">Download</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<h2 class="text-xl font-bold mb-2">Recent Invoices</h2>
<div class="overflow-x-auto">
    <table class="bg-white rounded shadow">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentInvoices as $invoice)
            <tr class="hover:bg-gray-50">
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ ucfirst($invoice->type) }}</td>
                <td>₹{{ number_format($invoice->amount, 2) }}</td>
                <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                <td><a href="{{ route('invoice.download', $invoice->id) }}" class="text-teal-600 hover:underline">Download</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
