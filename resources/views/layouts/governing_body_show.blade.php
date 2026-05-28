@extends('layouts.dashboard')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Governing Body Members</h2>
    <a href="{{ route('dashboard.governing_body.create') }}" class="btn-action" style="background:#0f9d94;">+ Add Member</a>
</div>

<div style="overflow-x: auto;">
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Post</th>
                <th>Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>
                    @if($member->image)
                    <img src="{{ asset('storage/' . $member->image) }}" width="60" height="60" style="object-fit:cover; border-radius:5px;">
                    @else
                    No Image
                    @endif
                </td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->post }}</td>
                <td>{{ $member->order }}</td>
                <td>
                    <a href="{{ route('dashboard.governing_body.edit', $member->id) }}" class="btn-action" style="background: #ffc107; color:#000;">Edit</a>
                    
                    <form action="{{ route('dashboard.governing_body.delete', $member->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this member?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:#dc3545; color:white; border:none; padding:5px 12px; border-radius:6px; cursor:pointer;">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            
            @if($members->count() == 0)
            <tr>
                <td colspan="5" style="text-align:center;">No members found.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
