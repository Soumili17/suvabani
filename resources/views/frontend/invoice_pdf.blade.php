<h2 style="text-align:center;">INVOICE</h2>

<hr>

<table width="100%">
<tr>
<td>
<strong>SUVABANI FOUNDATION</strong><br>
West Bengal, India<br>
contact@suvabanifoundation.com
</td>

<td align="right">
<strong>Invoice No:</strong> {{ $donation->receipt_number }}<br>
<strong>Date:</strong> {{ date('d M Y', strtotime($donation->created_at)) }}
</td>
</tr>
</table>

<hr>

<h4>Donor Details</h4>
<p>
Name: {{ $donation->name ?? 'N/A' }} <br>
Phone: {{ $donation->phone ?? 'N/A' }} <br>
Email: {{ $donation->address ?? 'N/A' }}
</p>

<hr>

<table width="100%" border="1" cellspacing="0" cellpadding="8">
<tr>
<th>Description</th>
<th>Amount</th>
</tr>

<tr>
<td>Donation - {{ $donation->donation_purpose ?? 'General Donation' }}</td>
<td> {{ number_format($donation->amount,2) }}</td>
</tr>

<tr>
<td><strong>Total</strong></td>
<td><strong> {{ number_format($donation->amount,2) }}</strong></td>
</tr>
</table>

<br><br>

<p>Payment Method: Razorpay</p>
<p>Payment ID: {{ $donation->razorpay_payment_id }}</p>

<br>

<p style="text-align:center;">
Thank you for your contribution
</p>