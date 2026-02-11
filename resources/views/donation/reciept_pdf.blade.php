<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Receipt - {{ $donation->donor_name ?? 'Donor' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 700px;
            margin: 30px auto;
            padding: 20px;
            border: 2px solid #555;
            border-radius: 10px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
        }

        header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .content {
            margin-top: 20px;
        }

        .content h2 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .details, .footer {
            margin-top: 15px;
            font-size: 14px;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details th, .details td {
            padding: 8px;
            border: 1px solid #aaa;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature img {
            width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>SUVABANI FOUNDATION (শুভাবনী ফাউন্ডেশন)</h1>
            <p>Govt. Registration No. IV-160300107/2025</p>
            <p>Rania Pravat Pally, P.O. Boral, P.S. Narendrapur, Kolkata - 700154</p>
            <h2>Donation Receipt (Form 80C)</h2>
        </header>

        <div class="content">
            <h2>Donor Details</h2>
            <div class="details">
                <table>
                    <tr>
                        <th>Name</th>
                        <td>{{ $donation->donor_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $donation->donor_email ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $donation->donor_phone ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $donation->donor_address ?? '' }}</td>
                    </tr>
                </table>
            </div>

            <h2>Donation Details</h2>
            <div class="details">
                <table>
                    <tr>
                        <th>Donation ID</th>
                        <td>{{ $donation->id }}</td>
                    </tr>
                    <tr>
                        <th>Amount (₹)</th>
                        <td>{{ number_format($donation->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ $donation->created_at->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Payment Method</th>
                        <td>{{ $donation->payment_method ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <div class="signature">
                <p>Authorized Signatory</p>
                @if(isset($donation->signature_path))
                    <img src="{{ storage_path('app/public/'.$donation->signature_path) }}" alt="Signature">
                @endif
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your generous contribution. Your donation is eligible for tax deduction under Section 80C of the Income Tax Act.</p>
        </div>
    </div>
</body>
</html>
