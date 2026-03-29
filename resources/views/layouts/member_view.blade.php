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

    <button type="submit">Search</button>
</form>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Status</th>
    <th>Payment</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($members as $member)
<tr>
    <td>{{ $member->membership_id ?? 'N/A' }}</td>
    <td>{{ $member->name }}</td>
    <td>{{ $member->phone }}</td>
    <td>{{ $member->email }}</td>

    <td>
        <span class="badge {{ strtolower($member->approval_status) }}">
            {{ $member->approval_status }}
        </span>
    </td>

    <td>{{ $member->payment_status }}</td>

    <td class="actions">
        <a href="{{ route('dashboard.members.view', $member->id) }}">View</a>
        <a href="{{ route('dashboard.members.edit', $member->id) }}">Edit</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="7">No members found</td>
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