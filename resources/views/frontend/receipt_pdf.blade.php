<!DOCTYPE html>
<html>
<head>
    <title>Form 80C Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin: 20px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SUVABANI FOUNDATION</h2>
        <p>Form 80C Donation Receipt</p>
        <hr>
    </div>

    <div class="content">
        <p><strong>Donor Name:</strong> {{ $donor->name }}</p>
        <p><strong>Email:</strong> {{ $donor->email }}</p>
        <p><strong>Phone:</strong> {{ $donor->phone }}</p>
        <p><strong>Address:</strong> {{ $donor->address }}</p>
        <p><strong>Amount Donated:</strong> ₹{{ number_format($donation->amount, 2) }}</p>
        <p><strong>Receipt Number:</strong> {{ $donation->receipt_number }}</p>
        <p><strong>Date:</strong> {{ $donation->created_at->format('d-m-Y') }}</p>
    </div>

    <div class="footer">
        <p>Thank you for your donation!</p>
        <p>This receipt is valid for Income Tax purposes under Section 80C.</p>
    </div>
</body>
</html>
