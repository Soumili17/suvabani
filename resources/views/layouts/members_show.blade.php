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
    background:#0f9d94;
    color:white;
}

.btn-action{
    padding:6px 12px;
    background:#008080;
    color:white;
    border-radius:6px;
    text-decoration:none;
    margin-right:5px;
}

.btn-action:hover{
    background:#0b8077;
}

.success{
    background:#d4edda;
    color:#155724;
    padding:10px;
    margin-bottom:20px;
    border-radius:5px;
    text-align:center;
}
</style>

<h2>Suvabani Members</h2>

@if(session('success'))
<div class="success">
{{ session('success') }}
</div>
@endif

@if($members->isEmpty())

<p>No members found.</p>

@else

<table>

<tr>
<th>Full Name</th>
<th>Email</th>
<th>Phone</th>
<th>Membership</th>
<th>Interest</th>
<th>Action</th>
</tr>

@foreach($members as $member)

<tr>

<td>{{ $member->fullname }}</td>

<td>{{ $member->email }}</td>

<td>{{ $member->phone }}</td>

<td>
{{ is_array($member->membership) ? implode(', ', $member->membership) : $member->membership }}
</td>

<td>
{{ is_array($member->interest) ? implode(', ', $member->interest) : $member->interest }}
</td>

<td>

<a href="{{ route('dashboard.members.view',$member->id) }}" class="btn-action">
View
</a>

<a href="{{ route('dashboard.members.edit',$member->id) }}" class="btn-action">
Edit
</a>

<form action="{{ route('dashboard.members.delete',$member->id) }}" 
method="POST" 
style="display:inline;">

@csrf
@method('DELETE')

<button type="submit"
onclick="return confirm('Delete this member?')"
class="btn-action">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</table>

@endif

@endsection