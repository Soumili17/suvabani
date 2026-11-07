<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #243447; font-size: 14px; }
        h1 { color: #003f88; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        th, td { border: 1px solid #ccd5df; padding: 10px; text-align: left; }
        th { background: #eef4fa; }
        .total { text-align: right; margin-top: 24px; font-size: 18px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>SUVABANI FOUNDATION</h1>
    <p><strong>Invoice number:</strong> {{ $invoice->invoice_number }}</p>
    <p><strong>Date:</strong> {{ $invoice->created_at?->format('d M Y') ?? now()->format('d M Y') }}</p>
    <p><strong>Customer:</strong> {{ $invoice->user?->name ?? '—' }}</p>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ ucfirst($invoice->type) }} invoice</td>
                <td>{{ ucfirst($invoice->type) }}</td>
                <td>₹{{ number_format((float) $invoice->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <p class="total">Total: ₹{{ number_format((float) $invoice->amount, 2) }}</p>
</body>
</html>
