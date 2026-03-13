@extends('layouts.dashboard')

@section('content')

<h2>Donor Details</h2>

<table>

<tr>
<td><b>Name</b></td>
<td>{{ $donor->donor_name }}</td>
</tr>

<tr>
<td><b>Email</b></td>
<td>{{ $donor->donor_email }}</td>
</tr>

<tr>
<td><b>Phone</b></td>
<td>{{ $donor->donor_phone }}</td>
</tr>

<tr>
<td><b>City</b></td>
<td>{{ $donor->donor_city }}</td>
</tr>

<tr>
<td><b>Amount</b></td>
<td>₹{{ $donor->amount }}</td>
</tr>

<tr>
<td><b>Purpose</b></td>
<td>{{ $donor->donation_purpose }}</td>
</tr>

<tr>
<td><b>Receipt</b></td>
<td>{{ $donor->receipt_number }}</td>
</tr>

<tr>
<td><b>Status</b></td>
<td>{{ $donor->payment_status }}</td>
</tr>

</table>

<br>

<a href="{{ route('dashboard.donors') }}" class="btn-action">
Back
</a>

@endsection