<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Donation Receipt & 80G Certificate</title>

<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    margin:0;
    padding:0 40px 30px 40px;
    font-size:13px;
    color:#000;
    line-height:1.6;
}

/* LETTERHEAD */
.letterhead{
    width:100%;
    text-align:center;
    margin-bottom:20px;
}

.letterhead img{
    width:100%;
    height:auto;
}

/* TITLE */
.title{
    text-align:center;
    font-size:20px;
    font-weight:bold;
    margin:20px 0;
    text-transform:uppercase;
    line-height:30px;
}

/* INFO TABLE */
.info-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:25px;
}

.info-table td{
    border:1px solid #000;
    padding:8px;
    font-size:12px;
}

.info-table td:first-child{
    width:35%;
    font-weight:bold;
}

/* SECTION HEADING */
.section-title{
    font-size:16px;
    font-weight:bold;
    margin-top:20px;
    margin-bottom:10px;
    text-transform:uppercase;
    border-bottom:1px solid #000;
    padding-bottom:5px;
}

/* CONTENT */
.content{
    text-align:justify;
    margin-bottom:15px;
}

/* DONATION TABLE */
.receipt-table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.receipt-table td{
    border:1px solid #000;
    padding:8px;
    font-size:12px;
}

.receipt-table td:first-child{
    width:45%;
    font-weight:bold;
}

/* SIGNATURE */
.signature{
    margin-top:60px;
    text-align:right;
}

.signature img{
    width:140px;
    height:auto;
}

.sign-name{
    margin-top:5px;
    font-weight:bold;
}

.sign-designation{
    font-size:12px;
}

/* FOOTER */
.footer{
    margin-top:40px;
    border-top:1px solid #000;
    padding-top:10px;
    font-size:11px;
}

</style>

</head>

<body>

<!-- LETTERHEAD -->
<div class="letterhead">

    <!-- Use cropped letterhead image -->
    <img src="{{ public_path('assests/images/letterhead.png') }}">

</div>

<!-- TITLE -->
<div class="title">
    Donation Receipt & Certificate<br>
    Under Section 80G Of The Income Tax Act, 1961
</div>

<!-- ORGANIZATION DETAILS -->
<table class="info-table">

    <tr>
        <td><strong>Name of Organization</strong></td>
        <td><strong>SUVABANI FOUNDATION</strong></td>
    </tr>

    <tr>
        <td><strong>Address</strong></td>
        <td>
            RANIA PRAVAT PALLY,<br>
            PO-BORAL,<br>
            PS-NARENDRAPUR,<br>
            KOLKATA - 700154
        </td>
    </tr>

    <tr>
        <td><strong>Registration No. (12A)</strong></td>
        <td>ABLTS3949LE20251</td>
    </tr>

    <tr>
        <td><strong>Approval No. (80G)</strong></td>
        <td>ABLTS3949LF20251</td>
    </tr>

    <tr>
        <td><strong>Date of Approval</strong></td>
        <td>10-07-2025</td>
    </tr>

    <tr>
        <td><strong>Certificate No.</strong></td>
        <td>{{ $receipt_no }}</td>
    </tr>

    <tr>
        <td><strong>Date of Issue</strong></td>
        <td>{{ $created_at }}</td>
    </tr>

</table>

<!-- DONOR DETAILS -->
<table class="info-table">

    <tr>
        <td>Donor Name</td>
        <td>{{ $donor_name }}</td>
    </tr>

    <tr>
        <td>Address</td>
        <td>{{ $donor_address }}</td>
    </tr>

    <tr>
        <td>PAN Number</td>
        <td>{{ $donor_pan }}</td>
    </tr>

</table>

<!-- DONATION RECEIPT -->
<div class="section-title">
    Donation Receipt
</div>

<div class="content">

    Received with thanks from
    <strong>{{ $donor_name }}</strong>,
    having PAN
    <strong>{{ $donor_pan }}</strong>,
    a sum of
    <strong>INR {{ $amount }}</strong>
    (Rupees {{ $amount_in_words }} Only)
    towards donation to
    <strong>SUVABANI FOUNDATION</strong>
    through
    <strong>{{ $payment_mode }}</strong>
    vide Transaction Reference Number
    <strong>{{ $transaction_id }}</strong>.

</div>

<!-- RECEIPT DETAILS -->
<table class="receipt-table">

    <tr>
        <td>Donation Date</td>
        <td>{{ $created_at }}</td>
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
        <td>Amount Received (Figures)</td>
        <td>INR {{ $amount }}</td>
    </tr>

    <tr>
        <td>Amount Received (Words)</td>
        <td>{{ $amount_in_words }} Only</td>
    </tr>

</table>

<!-- 80G CERTIFICATE -->
<div class="section-title">
    Certificate Under Section 80G
</div>

<div class="content">

    This is to certify that
    <strong>SUVABANI FOUNDATION</strong>
    is registered and approved under
    Section 80G of the Income Tax Act, 1961.

    The donation amount mentioned above has been received by the Foundation
    and is eligible for deduction under Section 80G of the Income Tax Act,
    subject to the provisions and conditions prescribed therein.

    The approval has been granted vide Certificate Number
    <strong>{{ $receipt_no }}</strong>.

</div>

<!-- SIGNATURE -->
<div class="signature">

    <img src="{{ public_path('assests/images/sign.png') }}">

    <div class="sign-name">
        Authorized Signatory
    </div>

    <div class="sign-designation">
        SUVABANI FOUNDATION
    </div>

</div>

<!-- FOOTER -->
<div class="footer">

    <strong>SUVABANI FOUNDATION</strong><br>

    Registered Office:
    RANIA PRAVAT PALLY, P.O.-BORAL, P.S.-NARENDRAPUR, KOLKATA - 700154

    <br>

    Email:
    contact@suvabanifoundation.com

</div>

</body>
</html>
