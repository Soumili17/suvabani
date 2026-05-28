@extends('layouts.dashboard')

@section('content')
<h2>Edit Governing Body Member</h2>

<form action="{{ route('dashboard.governing_body.update', $member->id) }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin-top: 20px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Name</label>
        <input type="text" name="name" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;" value="{{ old('name', $member->name) }}">
        @error('name')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Post / Role</label>
        <input type="text" name="post" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;" value="{{ old('post', $member->post) }}">
        @error('post')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Description</label>
        <textarea name="description" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px; min-height:120px;">{{ old('description', $member->description) }}</textarea>
        @error('description')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Order (Sorting)</label>
        <input type="number" name="order" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;" value="{{ old('order', $member->order) }}">
        @error('order')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Image (Leave blank to keep current image)</label>
        @if($member->image)
            <div style="margin-bottom: 10px;">
                <img src="{{ asset('storage/' . $member->image) }}" width="100" style="border-radius:5px;">
            </div>
        @endif
        <input type="file" name="image" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;" accept="image/*">
        @error('image')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <button type="submit" style="background:#0f9d94; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; font-size:16px;">
        Update Member
    </button>
    <a href="{{ route('dashboard.governing_body.index') }}" style="margin-left: 10px; color: #555; text-decoration: none;">Cancel</a>
</form>
@endsection
