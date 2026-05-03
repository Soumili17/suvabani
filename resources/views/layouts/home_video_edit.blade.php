@extends('layouts.dashboard')

@section('content')

<style>
.form-group{ margin-bottom:15px; }
label{ font-weight:bold; display:block; margin-bottom:5px; }
input{ width:100%; padding:8px; border:1px solid #ccc; border-radius:6px; }
.btn-save{ padding:10px 18px; background:#0f766e; color:white; border:none; border-radius:6px; cursor:pointer; }
.btn-save:hover{ background:#115e59; }
</style>

<h2>Manage Home Video</h2>
<p>Update the YouTube video shown on the homepage.</p>

<form method="POST" action="{{ route('dashboard.home_video.update') }}" style="max-width: 600px;">
    @csrf

    <div class="form-group">
        <label>Video Section Title</label>
        <input type="text" name="title" value="{{ $video->title ?? '' }}" placeholder="Our Work in Action">
    </div>

    <div class="form-group">
        <label>YouTube Video URL *</label>
        <input type="url" name="youtube_url" value="{{ $video->youtube_url ?? '' }}" required placeholder="https://www.youtube.com/watch?v=...">
    </div>

    <button type="submit" class="btn-save">Update Video</button>
</form>

@if(isset($video) && $video->youtube_url)
    <div style="margin-top: 30px;">
        <h3>Current Video Preview</h3>
        <iframe width="100%" height="315" src="{{ youtubeEmbedUrl($video->youtube_url) }}" frameborder="0" allowfullscreen></iframe>
    </div>
@endif

@endsection
