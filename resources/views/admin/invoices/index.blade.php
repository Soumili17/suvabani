@extends('layouts.dashboard')

@section('content')
<h2 style="color:#0f9d94;">Invoices</h2>

@if ($invoices->isEmpty())
    <p style="margin-top:20px; padding:16px; background:#f4fbfb; border-radius:8px;">No invoices found.</p>
@else
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Invoice number</th>
                    <th>Type</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Invoice file</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ ucfirst($invoice->type) }}</td>
                        <td>{{ $invoice->user?->name ?? '—' }}</td>
                        <td>₹{{ number_format((float) $invoice->amount, 2) }}</td>
                        <td>{{ $invoice->created_at?->format('d M Y') ?? '—' }}</td>
                        <td>
                            @if ($invoice->pdf_path)
                                <a href="{{ asset('storage/' . $invoice->pdf_path) }}" target="_blank" rel="noopener">View PDF</a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $invoices->links() }}
    </div>
@endif
@endsection
