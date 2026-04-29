@extends('layouts.dashboard')

@section('content')

<style>
.form-container{
    max-width:700px;
    background:white;
    padding:25px;
    border:1px solid #e5e7eb;
    border-radius:8px;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:5px;
    font-weight:bold;
}

.form-group input,
.form-group select{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:6px;
}

.btn-submit,
.btn-action{
    display:inline-block;
    background:#0f766e;
    color:white;
    padding:8px 14px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    text-decoration:none;
}

.preview{
    margin-top:10px;
    width:180px;
    height:110px;
    object-fit:cover;
    border-radius:6px;
    border:1px solid #ddd;
}

.error{
    color:red;
    font-size:14px;
}
</style>

<h2>Edit Gallery Item</h2>

<div class="form-container">
    <form method="POST" action="{{ route('dashboard.gallery.update', $gallery->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title', $gallery->title) }}">
            @error('title') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category">
                <option value="">-- Select Category --</option>
                @foreach(['Child Welfare', 'Women Empowerment', 'Healthcare Support', 'Education for All'] as $category)
                    <option value="{{ $category }}" @selected(old('category', $gallery->category) === $category)>{{ $category }}</option>
                @endforeach
            </select>
            @error('category') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Upload Type</label>
            <select name="type" id="typeSelect" onchange="toggleFields(this.value)">
                <option value="image" @selected(old('type', $gallery->type) === 'image')>Image</option>
                <option value="youtube" @selected(old('type', $gallery->type) === 'youtube')>YouTube Video</option>
            </select>
            @error('type') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group" id="imageField">
            <label>Upload Image</label>
            <input type="file" name="image" accept="image/*" onchange="previewImage(event)">

            @if($gallery->image)
                <img id="imagePreview" class="preview" src="{{ asset('storage/'.$gallery->image) }}" alt="{{ $gallery->title }}">
            @else
                <img id="imagePreview" class="preview" style="display:none;" alt="Image preview">
            @endif

            @error('image') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group" id="videoField">
            <label>YouTube URL</label>
            <input type="text" name="video_url" value="{{ old('video_url', $gallery->video_url) }}" placeholder="https://youtube.com/watch?v=...">
            @error('video_url') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-submit">Update</button>
        <a href="{{ route('dashboard.gallery') }}" class="btn-action">Back</a>
    </form>
</div>

<script>
function toggleFields(type){
    document.getElementById('imageField').style.display = type === 'image' ? 'block' : 'none';
    document.getElementById('videoField').style.display = type === 'youtube' ? 'block' : 'none';
}

function previewImage(event){
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');

    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
}

toggleFields(document.getElementById('typeSelect').value);
</script>

@endsection
