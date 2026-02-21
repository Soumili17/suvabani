@extends('layouts.dashboard')

@section('content')
<h2>Contact Messages</h2>

@if($messages->isEmpty())
    <p>No messages found.</p>
@else
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    @foreach($messages as $msg)
    <tr>
        <td>{{ $msg->id }}</td>
        <td>{{ $msg->name }}</td>
        <td>{{ $msg->email }}</td>
        <td>{{ $msg->message }}</td>
        <td>{{ $msg->created_at->format('d-m-Y H:i') }}</td>
        <td>
            <form action="{{ route('dashboard.messages.delete', $msg->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endif
@endsection