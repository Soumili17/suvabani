@extends('layouts.dashboard')

@section('content')

<style>
.container{
    width:90%;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}
.section{ margin-top:25px; }
.section h3{
    background:#0f766e;
    color:white;
    padding:8px;
    border-radius:5px;
}
.row{
    display:flex;
    flex-wrap:wrap;
    margin-bottom:8px;
}
.label{
    width:220px;
    font-weight:bold;
}
.value{ flex:1; }

.badge{
    padding:4px 10px;
    border-radius:5px;
    color:white;
}
.approved{ background:green; }
.pending{ background:orange; }
.rejected{ background:red; }

.btn{
    padding:6px 12px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    color:white;
}
.btn-approve{ background:green; }
.btn-reject{ background:red; }
.btn-update{ background:#0f766e; }
</style>

<div class="container">

<h2>Member Details</h2>

<!-- STATUS -->
<div class="section">
<h3>Status</h3>

<div class="row"><div class="label">Membership ID</div><div class="value">{{ $member->membership_id ?? 'Not Generated' }}</div></div>

<div class="row">
<div class="label">Approval Status</div>
<div class="value">
<span class="badge {{ strtolower($member->approval_status) }}">
{{ $member->approval_status }}
</span>
</div>
</div>

<div class="row">
<div class="label">Issue Date</div>
<div class="value">
{{ $member->approved_at ? \Carbon\Carbon::parse($member->approved_at)->format('d M Y') : 'N/A' }}
</div>
</div>

<div class="row"><div class="label">Payment Status</div><div class="value">{{ $member->payment_status }}</div></div>
<div class="row"><div class="label">Subscription Status</div><div class="value">{{ $member->subscription_status ?? 'N/A' }}</div></div>

</div>

<!-- PERSONAL DETAILS -->
<div class="section">
<h3>Personal Details</h3>

<div class="row"><div class="label">Name</div><div class="value">{{ $member->name }}</div></div>
<div class="row"><div class="label">Parent Name</div><div class="value">{{ $member->parentname ?? 'N/A' }}</div></div>
<div class="row"><div class="label">DOB</div><div class="value">{{ $member->dob ?? 'N/A' }}</div></div>
<div class="row"><div class="label">Gender</div><div class="value">{{ $member->gender ?? 'N/A' }}</div></div>
<div class="row"><div class="label">Nationality</div><div class="value">{{ $member->nationality ?? 'N/A' }}</div></div>
<div class="row"><div class="label">Occupation</div><div class="value">{{ $member->occupation ?? 'N/A' }}</div></div>
<div class="row"><div class="label">Address</div><div class="value">{{ $member->address ?? 'N/A' }}</div></div>
<div class="row"><div class="label">Phone</div><div class="value">{{ $member->phone }}</div></div>
<div class="row"><div class="label">Email</div><div class="value">{{ $member->email }}</div></div>

</div>

<!-- ID DETAILS -->
<div class="section">
<h3>ID Details</h3>

<div class="row"><div class="label">ID Type</div><div class="value">{{ $member->idproof ?? 'N/A' }}</div></div>
<div class="row"><div class="label">ID Number</div><div class="value">{{ $member->idnumber ?? 'N/A' }}</div></div>

<div class="row">
<div class="label">ID File</div>
<div class="value">
@if($member->idfile)
<a href="{{ asset('storage/'.$member->idfile) }}" target="_blank">View ID</a>
@else
N/A
@endif
</div>
</div>

</div>

<!-- MEMBERSHIP -->
<div class="section">
<h3>Membership</h3>

<div class="row"><div class="label">Membership Type</div><div class="value">{{ $member->membership_type }}</div></div>
<div class="row"><div class="label">Paid Amount</div><div class="value">₹ {{ $member->paid_amount }}</div></div>

</div>

<!-- OTHER -->
<div class="section">
<h3>Other Info</h3>

<div class="row"><div class="label">Interest</div><div class="value">{{ $member->interest ?? 'N/A' }}</div></div>
<div class="row"><div class="label">Experience</div><div class="value">{{ $member->experience ?? 'N/A' }}</div></div>
<div class="row"><div class="label">Languages</div><div class="value">{{ $member->languages ?? 'N/A' }}</div></div>
<div class="row"><div class="label">Time</div><div class="value">{{ $member->time ?? 'N/A' }}</div></div>
<div class="row"><div class="label">Reason</div><div class="value">{{ $member->reason ?? 'N/A' }}</div></div>

</div>

<!-- DOCUMENTS -->
<div class="section">
<h3>Documents</h3>

@if($member->photo)
<img src="{{ asset('storage/'.$member->photo) }}" width="120">
@endif

@if($member->signature)
<img src="{{ asset('storage/'.$member->signature) }}" width="120">
@endif

</div>

<!-- REUPLOAD -->
<div class="section">
<h3>Reupload Documents</h3>

<form action="{{ route('dashboard.members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
@csrf

<input type="file" name="photo">
<input type="file" name="signature">
<input type="file" name="idfile">

<button class="btn btn-update">Update</button>

</form>

</div>

<!-- ACTIONS -->
<div class="section">
<h3>Actions</h3>

<form action="{{ route('dashboard.members.approve', $member->id) }}" method="POST" style="display:inline;">
@csrf
<button class="btn btn-approve">Approve</button>
</form>

<form action="{{ route('dashboard.members.reject', $member->id) }}" method="POST" style="display:inline;">
@csrf
<button class="btn btn-reject">Reject</button>
</form>

</div>

</div>

@endsection