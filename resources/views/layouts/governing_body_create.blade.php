@extends('layouts.dashboard')

@section('content')
<h2>Add Governing Body Member</h2>

<form action="{{ route('dashboard.governing_body.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin-top: 20px;">
    @csrf

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Name</label>
        <input type="text" name="name" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;" value="{{ old('name') }}">
        @error('name')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Post / Role</label>
        <input type="text" name="post" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;" value="{{ old('post') }}">
        @error('post')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Description</label>
        <textarea name="description" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px; min-height:120px;">{{ old('description') }}</textarea>
        @error('description')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Order (Sorting)</label>
        <input type="number" name="order" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;" value="{{ old('order', 0) }}">
        @error('order')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Image</label>
        <input type="file" name="image" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;" accept="image/*">
        @error('image')<div style="color:red; font-size:12px;">{{ $message }}</div>@enderror
    </div>

    <button type="submit" style="background:#0f9d94; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; font-size:16px;">
        Save Member
    </button>
    <a href="{{ route('dashboard.governing_body.index') }}" style="margin-left: 10px; color: #555; text-decoration: none;">Cancel</a>
</form>
@endsection
