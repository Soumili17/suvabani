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

.page-title{
    font-size:24px;
    margin-bottom:10px;
}

.alert-success{
    background:#d1fae5;
    color:#065f46;
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
}
</style>

<h2 class="page-title">All Volunteers</h2>

<!-- SUCCESS MESSAGE -->
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- ADD BUTTON -->
<a href="{{ route('dashboard.volunteers.create') }}" class="btn-action">
+ Add Volunteer
</a>

<!-- SEARCH -->
<form method="GET" action="{{ route('dashboard.volunteers') }}" style="margin:15px 0;">
    <input type="text" 
           name="search" 
           placeholder="Search name, email or phone"
           value="{{ request('search') }}"
           style="padding:8px;width:250px;">

    <button type="submit" class="btn-action">Search</button>

    <a href="{{ route('dashboard.volunteers') }}" class="btn-action">Reset</a>
</form>

@if($volunteers->isEmpty())
<p>No volunteers found.</p>
@else

<table>
<tr>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>ID Card</th>
<th>Date</th>
<th>Action</th>
</tr>

@foreach($volunteers as $v)

<tr>
<td>{{ $v->name }}</td>
<td>{{ $v->email }}</td>
<td>{{ $v->phone }}</td>

<td>
@if($v->id_card)
    <a href="{{ asset('storage/'.$v->id_card) }}" target="_blank" class="btn-action">
        View
    </a>
@else
    N/A
@endif
</td>

<td>{{ $v->created_at->format('d-m-Y') }}</td>

<td>
<a href="{{ route('dashboard.volunteers.edit',$v->id) }}" class="btn-action">
Edit
</a>

<form action="{{ route('dashboard.volunteers.delete',$v->id) }}" 
method="POST" 
style="display:inline;">
@csrf
@method('DELETE')

<button type="submit"
onclick="return confirm('Delete this volunteer?')"
class="btn-action">
Delete
</button>
</form>
</td>

</tr>

@endforeach

</table>

<!-- ✅ FIXED PAGINATION -->
<div style="margin-top:20px;">
{{ $volunteers->appends(request()->query())->links() }}
</div>

@endif

@endsection