@extends('layouts.dashboard')

@section('content')

<style>
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th,td{
    border:1px solid #ddd;
    padding:10px;
    text-align:left;
}

th{
    background:#0f766e;
    color:white;
}

.btn-action{
    padding:6px 12px;
    background:#0f766e;
    color:white;
    border-radius:6px;
    text-decoration:none;
    margin-right:5px;
    border:none;
    cursor:pointer;
}

.btn-action:hover{
    background:#115e59;
}

.status-paid{
    color:green;
    font-weight:bold;
}

.status-pending{
    color:orange;
    font-weight:bold;
}

.status-failed{
    color:red;
    font-weight:bold;
}

.page-title{
    font-size:24px;
    margin-bottom:10px;
}
</style>

<h2 class="page-title">All Donations</h2>

@if($donors->isEmpty())
<p>No donors found.</p>
@else
<form method="GET" action="{{ route('dashboard.donors') }}" style="margin-bottom:15px;">

<input type="text" 
name="search" 
placeholder="Search name, email or phone"
value="{{ request('search') }}"
style="padding:8px;width:250px;">

<button type="submit" class="btn-action">
Search
</button>

<a href="{{ route('dashboard.donors') }}" class="btn-action">
Reset
</a>

</form>
<table>

<tr>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>City</th>
<th>Amount</th>
<th>Purpose</th>
<th>80G</th>
<th>Status</th>
<th>Receipt</th>
<th>Date</th>
<th>Action</th>
</tr>

@foreach($donors as $donor)

<tr>

<td>{{ $donor->donor_name }}</td>

<td>{{ $donor->donor_email }}</td>

<td>{{ $donor->donor_phone }}</td>

<td>{{ $donor->donor_city }}</td>

<td>₹{{ $donor->amount }}</td>

<td>{{ $donor->donation_purpose }}</td>

<td>
@if($donor->need_80g)
Yes
@else
No
@endif
</td>

<td>
@if($donor->payment_status == 'Paid')
<span class="status-paid">Paid</span>

@elseif($donor->payment_status == 'Pending')
<span class="status-pending">Pending</span>

@else
<span class="status-failed">Failed</span>
@endif
</td>

<td>{{ $donor->receipt_number }}</td>

<td>{{ $donor->donation_date }}</td>

<td>

<a href="{{ route('dashboard.donors.view',$donor->id) }}" class="btn-action">
View
</a>

<a href="{{ route('dashboard.donors.edit',$donor->id) }}" class="btn-action">
Edit
</a>

<form action="{{ route('dashboard.donors.delete',$donor->id) }}" 
method="POST" 
style="display:inline;">

@csrf
@method('DELETE')

<button type="submit"
onclick="return confirm('Delete this donor?')"
class="btn-action">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</table>
<div style="margin-top:20px;">
{{ $donors->links() }}
</div>
@endif

@endsection