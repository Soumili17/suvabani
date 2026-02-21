<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Members</title>
<style>
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { border:1px solid #ddd; padding:10px; text-align:left; }
th { background:#0f9d94; color:white; }
a.btn-action { padding:5px 12px; background:#008080; color:white; border-radius:6px; text-decoration:none; margin-right:5px;}
a.btn-action:hover { background:#0b8077;}
.success { background:#d4edda;color:#155724;padding:10px;margin-bottom:20px;border-radius:5px;text-align:center;}
</style>
</head>
<body>
@extends('layouts.dashboard')

@section('content')
<h2>Suvabani Members</h2>

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
        <td>{{ is_array($member->membership) ? implode(', ', $member->membership) : $member->membership }}</td>
        <td>{{ is_array($member->interest) ? implode(', ', $member->interest) : $member->interest }}</td>
        <td>
            <a href="#" class="btn-action">Edit</a>
            <a href="{{ route('dashboard.members.delete', $member->id) }}" onclick="return confirm('Are you sure?')" class="btn-action">Delete</a>
        </td>
    </tr>
    @endforeach
@endif
@endsection


</body>
</html>