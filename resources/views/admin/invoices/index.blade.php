@extends('layouts.admin')

@section('title', 'All Invoices')

@section('content')
<h1>All Invoices</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Invoice Number</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->invoice_number }}</td>
            <td>{{ ucfirst($invoice->type) }}</td>
            <td>₹{{ number_format($invoice->amount, 2) }}</td>
            <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
            <td>
                <a href="{{ route('invoice.download', $invoice->id) }}">Download PDF</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $invoices->links() }}
@endsection
