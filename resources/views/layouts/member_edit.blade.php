@extends('layouts.dashboard')

@section('content')

<style>

.container{
width:90%;
margin:auto;
background:#fff;
padding:30px;
border-radius:10px;
box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

h2{
color:#0f766e;
margin-bottom:20px;
}

.section{
margin-top:25px;
}

.section h3{
background:#0f766e;
color:white;
padding:8px;
border-radius:5px;
margin-bottom:10px;
}

.row{
display:flex;
flex-wrap:wrap;
margin-bottom:10px;
}

.row label{
width:200px;
font-weight:bold;
}

.row input,
.row textarea,
.row select{
flex:1;
padding:8px;
border:1px solid #ccc;
border-radius:5px;
}

img{
margin-top:10px;
border-radius:6px;
border:1px solid #ddd;
}

button{
background:#0f766e;
color:white;
padding:10px 20px;
border:none;
border-radius:6px;
margin-top:20px;
cursor:pointer;
}

button:hover{
background:#0c5c58;
}

</style>

<div class="container">

<h2>Edit Member</h2>

<form method="POST" action="{{ route('dashboard.members.update',$member->id) }}" enctype="multipart/form-data">

@csrf


<!-- PHOTO -->

<div class="section">

<h3>Photo & Signature</h3>

<div class="row">
<label>Photo</label>
<input type="file" name="photo">

@if($member->photo)
<br>
<img src="{{ asset('storage/'.$member->photo) }}" width="120">
@endif
</div>

<div class="row">
<label>Signature</label>
<input type="file" name="signature">

@if($member->signature)
<br>
<img src="{{ asset('storage/'.$member->signature) }}" width="120">
@endif
</div>

</div>

<!-- PERSONAL DETAILS -->

<div class="section">

<h3>Personal Details</h3>

<div class="row">
<label>Full Name</label>
<input type="text" name="fullname" value="{{ $member->fullname }}">
</div>

<div class="row">
<label>Parent Name</label>
<input type="text" name="parentname" value="{{ $member->parentname }}">
</div>

<div class="row">
<label>DOB</label>
<input type="date" name="dob" value="{{ $member->dob }}">
</div>

<div class="row">
<label>Gender</label>
<select name="gender">
<option {{ $member->gender=='Male'?'selected':'' }}>Male</option>
<option {{ $member->gender=='Female'?'selected':'' }}>Female</option>
<option {{ $member->gender=='Other'?'selected':'' }}>Other</option>
</select>
</div>

<div class="row">
<label>Nationality</label>
<input type="text" name="nationality" value="{{ $member->nationality }}">
</div>

<div class="row">
<label>Occupation</label>
<input type="text" name="occupation" value="{{ $member->occupation }}">
</div>

<div class="row">
<label>Address</label>
<textarea name="address">{{ $member->address }}</textarea>
</div>

<div class="row">
<label>Phone</label>
<input type="text" name="phone" value="{{ $member->phone }}">
</div>

<div class="row">
<label>Email</label>
<input type="email" name="email" value="{{ $member->email }}">
</div>

</div>

<!-- ID PROOF -->

<div class="section">

<h3>ID Proof</h3>

<div class="row">
<label>ID Type</label>
<input type="text" name="idproof" value="{{ $member->idproof }}">
</div>

<div class="row">
<label>ID Number</label>
<input type="text" name="idnumber" value="{{ $member->idnumber }}">
</div>

<div class="row">
<label>ID File</label>
<input type="file" name="idfile">
</div>

</div>

<!-- MEMBERSHIP -->

<div class="section">

<h3>Membership</h3>

<div class="row">
<label>Membership</label>
<input type="text" name="membership" value="{{ $member->membership }}">
</div>

<div class="row">
<label>Paid Amount</label>
<input type="number" name="paidamount" value="{{ $member->paidamount }}">
</div>

<div class="row">
<label>Member Type</label>
<input type="text" name="membertype" value="{{ $member->membertype }}">
</div>

</div>

<!-- INTEREST -->

<div class="section">

<h3>Interest</h3>

<div class="row">
<label>Interest</label>
<input type="text" name="interest" value="{{ $member->interest }}">
</div>

<div class="row">
<label>Other Interest</label>
<input type="text" name="interest_other" value="{{ $member->interest_other }}">
</div>

</div>

<!-- OTHER -->

<div class="section">

<h3>Other Information</h3>

<div class="row">
<label>Experience</label>
<textarea name="experience">{{ $member->experience }}</textarea>
</div>

<div class="row">
<label>Languages</label>
<input type="text" name="languages" value="{{ $member->languages }}">
</div>

<div class="row">
<label>Time</label>
<input type="text" name="time" value="{{ $member->time }}">
</div>

<div class="row">
<label>Reason</label>
<textarea name="reason">{{ $member->reason }}</textarea>
</div>

<div class="row">
<label>Reference Name</label>
<input type="text" name="ref_name" value="{{ $member->ref_name }}">
</div>

<div class="row">
<label>Reference Mobile</label>
<input type="text" name="ref_mobile" value="{{ $member->ref_mobile }}">
</div>

</div>

<!-- DECLARATION -->

<div class="section">

<h3>Declaration</h3>

<div class="row">
<label>Date</label>
<input type="date" name="declaration_date" value="{{ $member->declaration_date }}">
</div>

</div>

<button type="submit">Update Member</button>

</form>

</div>

@endsection