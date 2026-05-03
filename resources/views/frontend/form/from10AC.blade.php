<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>80G Certificate</title>

<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    margin:40px;
    font-size:13px;
    color:#000;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.header img{
    height:60px;
}

.title{
    text-align:center;
    font-weight:bold;
    margin:10px 0;
}

.section{
    margin-top:15px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

td, th{
    border:1px solid #000;
    padding:6px;
    font-size:12px;
}

.no-border td{
    border:none;
    padding:2px 0;
}

.signature{
    margin-top:40px;
}

.signature img{
    height:50px;
}

.footer{
    margin-top:40px;
    font-size:11px;
    border-top:1px solid #000;
    padding-top:10px;
}

.small{
    font-size:11px;
}

</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <div>
        <strong>Receipt No:</strong> {{ $receipt_no }}<br>
        <strong>Date:</strong> {{ date('d F Y') }}
    </div>

    <img src="{{ public_path('assets/images/logo.png') }}">
</div>

<div class="title">80G Certificate</div>

<!-- DONOR DETAILS -->
<div class="section">
    <table class="no-border">
        <tr>
            <td><strong>Name:</strong> {{ $donor_name }}</td>
        </tr>
        <tr>
            <td><strong>Address:</strong> {{ $donor_address }}</td>
        </tr>
        <tr>
            <td><strong>PAN:</strong> {{ $donor_pan }}</td>
        </tr>
    </table>
</div>

<!-- MESSAGE -->
<div class="section">
    <p>
        Thank you for making a contribution of 
        <strong>Rs {{ $amount }}</strong> to <strong>SUVABANI FOUNDATION</strong>. 
        Please keep this receipt for your records.
    </p>
</div>

<!-- SIGNATURE -->
<div class="signature">
    <img src="{{ public_path('assets/images/sign.png') }}"><br>
    <span class="small">(Authorised Signatory)</span>
</div>

<hr>

<!-- DONATION RECEIPT TABLE -->
<div class="title">DONATION RECEIPT</div>

<table>
    <tr>
        <td>Donation Date</td>
        <td>{{ date('d F Y') }}</td>
    </tr>
    <tr>
        <td>Transaction Reference Number</td>
        <td>{{ $transaction_id }}</td>
    </tr>
    <tr>
        <td>Payment Mode</td>
        <td>{{ $payment_mode }}</td>
    </tr>
    <tr>
        <td>Total Contribution Received (Numbers)</td>
        <td>Rs {{ $amount }}</td>
    </tr>
    <tr>
        <td>Total Contribution Received (Words)</td>
        <td>{{ $amount_in_words }} Only</td>
    </tr>
</table>

<!-- 80G TEXT -->
<div class="section small">
    Donation to <strong>SUVABANI FOUNDATION</strong> qualifies for deduction under 
    section 80G(5) of Income Tax Act 1961 vide Unique Registration Number 
    <strong>{{ $registration_no }}</strong>.

    <br><br>

    This is a computer generated receipt. In case of any discrepancy please contact:
    {{ $email }}
</div>

<!-- FOOTER -->
<div class="footer">
    <strong>Registered Office Address:</strong> {{ $org_address }}
</div>

</body>
</html>