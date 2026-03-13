@extends('layouts.dashboard')

@section('content')

<style>

.edit-container{
    width:650px;
    background:#ffffff;
    padding:25px;
    border-radius:8px;
    box-shadow:0 0 12px rgba(0,0,0,0.1);
}

.form-group{
    margin-bottom:15px;
}

label{
    font-weight:bold;
    display:block;
    margin-bottom:5px;
}

input,select,textarea{
    width:100%;
    padding:8px;
    border:1px solid #ccc;
    border-radius:6px;
}

textarea{
    height:70px;
}

.btn-save{
    padding:10px 18px;
    background:#0f766e;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.btn-save:hover{
    background:#115e59;
}

.btn-back{
    margin-left:10px;
    text-decoration:none;
    color:#333;
}

</style>

<h2>Edit Donor Details</h2>

<div class="edit-container">

<form method="POST" action="{{ route('dashboard.donors.update',$donor->id) }}">

@csrf

<div class="form-group">
<label>Donor Name</label>
<input type="text" name="donor_name" value="{{ $donor->donor_name }}">
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="donor_email" value="{{ $donor->donor_email }}">
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="donor_phone" value="{{ $donor->donor_phone }}">
</div>

<div class="form-group">
<label>Address</label>
<textarea name="donor_address">{{ $donor->donor_address }}</textarea>
</div>

<div class="form-group">
<label>City</label>
<input type="text" name="donor_city" value="{{ $donor->donor_city }}">
</div>

<div class="form-group">
<label>State</label>
<input type="text" name="donor_state" value="{{ $donor->donor_state }}">
</div>

<div class="form-group">
<label>Pincode</label>
<input type="text" name="donor_pincode" value="{{ $donor->donor_pincode }}">
</div>

<div class="form-group">
<label>Donation Amount</label>
<input type="number" name="amount" value="{{ $donor->amount }}">
</div>

<div class="form-group">
<label>Donation Purpose</label>
<input type="text" name="donation_purpose" value="{{ $donor->donation_purpose }}">
</div>

<div class="form-group">
<label>Need 80G Certificate</label>

<select name="need_80g">

<option value="1" {{ $donor->need_80g ? 'selected' : '' }}>Yes</option>

<option value="0" {{ !$donor->need_80g ? 'selected' : '' }}>No</option>

</select>

</div>

<div class="form-group">
<label>PAN Number</label>
<input type="text" name="donor_pan" value="{{ $donor->donor_pan }}">
</div>

<div class="form-group">
<label>Payment Status</label>

<select name="payment_status">

<option value="Paid" {{ $donor->payment_status=='Paid'?'selected':'' }}>Paid</option>

<option value="Pending" {{ $donor->payment_status=='Pending'?'selected':'' }}>Pending</option>

<option value="Failed" {{ $donor->payment_status=='Failed'?'selected':'' }}>Failed</option>

</select>

</div>

<button type="submit" class="btn-save">
Update Donor
</button>

<a href="{{ route('dashboard.donors') }}" class="btn-back">
Cancel
</a>

</form>

</div>

@endsection