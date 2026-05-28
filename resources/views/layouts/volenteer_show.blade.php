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

.vol-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #0f766e;
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
           placeholder="Search by name or designation"
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
<th>Photo</th>
<th>Name</th>
<th>Designation</th>
<th>Date</th>
<th>Action</th>
</tr>

@foreach($volunteers as $v)

<tr>
<td>
@if($v->profile_pic)
    <img src="{{ asset('storage/'.$v->profile_pic) }}" class="vol-thumb" alt="{{ $v->name }}">
@else
    <span style="color:#aaa;">No Photo</span>
@endif
</td>
<td>{{ $v->name }}</td>
<td>{{ $v->designation ?? 'N/A' }}</td>
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

<!-- PAGINATION -->
<div style="margin-top:20px;">
{{ $volunteers->appends(request()->query())->links() }}
</div>

@endif

@endsection