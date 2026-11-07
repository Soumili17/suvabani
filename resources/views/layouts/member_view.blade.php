@extends('layouts.dashboard')

@section('content')

<style>
.container{
    width:95%;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}
table{
    width:100%;
    border-collapse:collapse;
}
th, td{
    padding:10px;
    border-bottom:1px solid #ddd;
    text-align:left;
}
th{
    background:#0f766e;
    color:white;
}
.badge{
    padding:4px 10px;
    border-radius:5px;
    color:white;
    font-size:12px;
}
.approved{ background:green; }
.pending{ background:orange; }
.rejected{ background:red; }
.actions a{
    margin-right:8px;
    text-decoration:none;
    color:#0f766e;
    font-weight:bold;
}
.search-box{
    margin-bottom:15px;
}
</style>

<div class="container">

<h2>Members List</h2>

<!-- SEARCH -->
<form method="GET" class="search-box">
    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
    
    <select name="status">
        <option value="">All Status</option>
        <option value="Approved" {{ request('status')=='Approved'?'selected':'' }}>Approved</option>
        <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
        <option value="Rejected" {{ request('status')=='Rejected'?'selected':'' }}>Rejected</option>
    </select>

    <input type="text" name="referral_code" placeholder="Filter by Referral Code" value="{{ request('referral_code') }}" style="max-width:200px;">

    <button type="submit">Search</button>
</form>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Member Type</th>
    <th>1st Payment Date</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Referral Code</th>
    <th>Status</th>
    <th>Payment</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($members as $member)
<tr>
    <td>{{ $member->membership_id ?? 'N/A' }}</td>
    <td>{{ $member->fullname }}</td>
    <td>
        @if(($member->membership ?? '') === 'Paid')
            <span style="background:#0f766e; color:white; padding:3px 8px; border-radius:4px; font-size:12px; font-weight:600;">Paid Member</span>
        @else
            <span style="background:#6c757d; color:white; padding:3px 8px; border-radius:4px; font-size:12px; font-weight:600;">Non-Paid Member</span>
        @endif
    </td>
    <td>{{ $member->first_payment_date }}</td>
    <td>{{ $member->phone }}</td>
    <td>{{ $member->email }}</td>

    <td>
        @if($member->referral_code)
            <span style="background:#e0f2fe; color:#0369a1; padding:2px 8px; border-radius:12px; font-size:12px; font-weight:600;">{{ $member->referral_code }}</span>
        @else
            <span style="color:#aaa; font-size:12px;">—</span>
        @endif
    </td>

    <td>
        <span class="badge {{ strtolower($member->approval_status) }}">
            {{ $member->approval_status }}
        </span>
    </td>

    <td>{{ $member->paidamount ?: 'N/A' }}</td>

    <td class="actions">
        <a href="{{ route('dashboard.members.view', $member->id) }}">View</a>
        <a href="{{ route('dashboard.members.edit', $member->id) }}">Edit</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="9">No members found</td>
</tr>
@endforelse

</tbody>
</table>

<!-- PAGINATION -->
<div style="margin-top:15px;">
    {{ $members->links() }}
</div>

</div>

@endsection