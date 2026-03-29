@extends('layouts.dashboard')

@section('content')

<style>

.container{ width:90%; margin:auto; background:white; padding:30px; border-radius:10px; box-shadow:0 5px 20px rgba(0,0,0,0.1); } h2{ margin-bottom:20px; color:#0f766e; } .section{ margin-top:25px; } .section h3{ background:#0f766e; color:white; padding:8px; border-radius:5px; margin-bottom:10px; } .row{ display:flex; flex-wrap:wrap; margin-bottom:8px; } .label{ width:250px; font-weight:bold; } .value{ flex:1; } img{ border-radius:8px; border:1px solid #ddd; margin-top:5px; } /* ================= MOBILE RESPONSIVE ================= */ @media (max-width:768px){ .container{ width:100%; padding:15px; border-radius:0; } h2{ font-size:20px; text-align:center; } .section h3{ font-size:16px; text-align:center; } /* Row becomes vertical */ .row{ flex-direction:column; } .label{ width:100%; margin-bottom:5px; font-size:14px; } .value{ width:100%; font-size:14px; } img{ width:100%; height:auto; } }

</style>

<div class="container">

<h2>Member Details</h2>

<!-- PHOTO & SIGNATURE -->

<div class="section">

<h3>Photo & Signature</h3>

<div class="row">
<div class="label">Photo</div>
<div class="value">

@if($member->photo)
<img src="{{ asset('storage/'.$member->photo) }}" width="120">
@endif

</div>
</div>

<div class="row">
<div class="label">Signature</div>
<div class="value">

@if($member->signature)
<img src="{{ asset('storage/'.$member->signature) }}" width="120">
@endif

</div>
</div>

</div>

<!-- PERSONAL DETAILS -->

<div class="section">

<h3>Personal Details</h3>

<div class="row"><div class="label">Full Name</div><div class="value">{{ $member->fullname }}</div></div>

<div class="row"><div class="label">Parent Name</div><div class="value">{{ $member->parentname }}</div></div>

<div class="row"><div class="label">Date of Birth</div><div class="value">{{ $member->dob }}</div></div>

<div class="row"><div class="label">Gender</div><div class="value">{{ $member->gender }}</div></div>

<div class="row"><div class="label">Nationality</div><div class="value">{{ $member->nationality }}</div></div>

<div class="row"><div class="label">Occupation</div><div class="value">{{ $member->occupation }}</div></div>

<div class="row"><div class="label">Address</div><div class="value">{{ $member->address }}</div></div>

<div class="row"><div class="label">Phone</div><div class="value">{{ $member->phone }}</div></div>

<div class="row"><div class="label">Email</div><div class="value">{{ $member->email }}</div></div>

</div>

<!-- ID PROOF -->

<div class="section">

<h3>ID Proof</h3>

<div class="row"><div class="label">ID Type</div><div class="value">{{ $member->idproof }}</div></div>

<div class="row"><div class="label">ID Number</div><div class="value">{{ $member->idnumber }}</div></div>

<div class="row"><div class="label">Other ID</div><div class="value">{{ $member->idproof_other }}</div></div>

<div class="row">

<div class="label">ID File</div>

<div class="value">

@if($member->idfile)
<a href="{{ asset('storage/'.$member->idfile) }}" target="_blank">View ID Proof</a>
@endif

</div>

</div>

</div>

<!-- MEMBERSHIP -->

<div class="section">

<h3>Membership</h3>

<div class="row">
<div class="label">Membership Type</div>
<div class="value">{{ $member->membership }}</div>
</div>

<div class="row">
<div class="label">Paid Amount</div>
<div class="value">₹ {{ $member->paidamount }}</div>
</div>

<div class="row">
<div class="label">Member Type</div>
<div class="value">{{ $member->membertype }}</div>
</div>

</div>

<!-- INTEREST -->

<div class="section">

<h3>Areas of Interest</h3>

<div class="row">
<div class="label">Interest</div>
<div class="value">{{ $member->interest }}</div>
</div>

<div class="row">
<div class="label">Other Interest</div>
<div class="value">{{ $member->interest_other }}</div>
</div>

</div>

<!-- OTHER INFORMATION -->

<div class="section">

<h3>Other Information</h3>

<div class="row"><div class="label">Experience</div><div class="value">{{ $member->experience }}</div></div>

<div class="row"><div class="label">Languages</div><div class="value">{{ $member->languages }}</div></div>

<div class="row"><div class="label">Available Time</div><div class="value">{{ $member->time }}</div></div>

<div class="row"><div class="label">Reason for Joining</div><div class="value">{{ $member->reason }}</div></div>

<div class="row"><div class="label">Reference Name</div><div class="value">{{ $member->ref_name }}</div></div>

<div class="row"><div class="label">Reference Mobile</div><div class="value">{{ $member->ref_mobile }}</div></div>

</div>

<!-- DECLARATION -->

<div class="section">

<h3>Declaration</h3>

<div class="row">
<div class="label">Declaration Date</div>
<div class="value">{{ $member->declaration_date }}</div>
</div>

</div>

</div>

@endsection