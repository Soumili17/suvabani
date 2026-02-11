
<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin: 20px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SUVABANI FOUNDATION</h2>
        <p>Invoice</p>
        <hr>
    </div>

    <div class="content">
        <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
        <p><strong>Date:</strong> {{ $invoice->created_at->format('d-m-Y') }}</p>
        <p><strong>Type:</strong> {{ ucfirst($invoice->type) }}</p>
        <p><strong>Amount:</strong> ₹{{ number_format($invoice->amount, 2) }}</p>
    </div>

    <div class="footer">
        <p>Thank you for your support!</p>
    </div>
</body>
</html>
