@extends('layouts.dashboard')

@section('content')

<style>
.gallery-admin-header{
    display:flex;
    justify-content:space-between;
    gap:15px;
    align-items:center;
    margin-bottom:20px;
}

.form-container{
    max-width:700px;
    background:white;
    padding:22px;
    border:1px solid #e5e7eb;
    border-radius:8px;
    margin-bottom:25px;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:15px;
}

.form-group{
    margin-bottom:15px;
}

.form-group.full{
    grid-column:1 / -1;
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

.btn-action,
.btn-submit{
    display:inline-block;
    background:#0f766e;
    color:white;
    padding:8px 14px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    text-decoration:none;
    font-size:14px;
}

.btn-danger{
    background:#dc3545;
}

.preview,
.thumb{
    width:120px;
    height:80px;
    object-fit:cover;
    border-radius:6px;
    border:1px solid #ddd;
}

.preview{
    margin-top:10px;
    display:none;
}

.video-link{
    color:#0f766e;
    font-weight:600;
}

.error{
    color:red;
    font-size:14px;
}

.gallery-table-wrap{
    overflow-x:auto;
}

@media (max-width:768px){
    .gallery-admin-header,
    .form-grid{
        display:block;
    }
}
</style>

<div class="gallery-admin-header">
    <div>
        <h2>Gallery Admin</h2>
        <p>Upload images or YouTube videos and manage the public gallery.</p>
    </div>

    <a href="{{ route('gallery') }}" target="_blank" class="btn-action">View Public Gallery</a>
</div>

<div class="form-container">
    <h3>Upload Gallery Item</h3>

    <form method="POST" action="{{ route('dashboard.gallery.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title') }}">
                @error('title') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    <option value="">-- Select Category --</option>
                    @foreach(['Child Welfare', 'Women Empowerment', 'Healthcare Support', 'Education for All'] as $category)
                        <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Upload Type</label>
                <select name="type" id="typeSelect" onchange="toggleFields(this.value)">
                    <option value="image" @selected(old('type', 'image') === 'image')>Image</option>
                    <option value="youtube" @selected(old('type') === 'youtube')>YouTube Video</option>
                </select>
                @error('type') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group" id="imageField">
                <label>Upload Image</label>
                <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
                <img id="imagePreview" class="preview" alt="Image preview">
                @error('image') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group full" id="videoField" style="display:none;">
                <label>YouTube URL</label>
                <input type="text" name="video_url" value="{{ old('video_url') }}" placeholder="https://youtube.com/watch?v=...">
                <iframe id="videoPreview" class="preview" height="150" frameborder="0" allowfullscreen></iframe>
                @error('video_url') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <button type="submit" class="btn-submit">Upload</button>
    </form>
</div>

<h3>All Gallery Items</h3>

@if($images->isEmpty())
    <p>No gallery items found.</p>
@else
    <div class="gallery-table-wrap">
        <table>
            <tr>
                <th>Preview</th>
                <th>Title</th>
                <th>Category</th>
                <th>Type</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            @foreach($images as $item)
                <tr>
                    <td>
                        @if($item->type === 'image' && $item->image)
                            <img class="thumb" src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}">
                        @elseif($item->type === 'youtube' && $item->video_url)
                            <a class="video-link" href="{{ $item->video_url }}" target="_blank">YouTube Video</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ ucfirst($item->type) }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('dashboard.gallery.edit', $item->id) }}" class="btn-action">Edit</a>

                        <form action="{{ route('dashboard.gallery.delete', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this gallery item?')" class="btn-action btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $images->links() }}
    </div>
@endif

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

function extractYouTubeId(url){
    const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/);
    return match ? match[1] : null;
}

document.querySelector('input[name="video_url"]').addEventListener('input', function(){
    const iframe = document.getElementById('videoPreview');
    const videoId = extractYouTubeId(this.value);

    if(videoId){
        iframe.src = 'https://www.youtube.com/embed/' + videoId;
        iframe.style.display = 'block';
    } else {
        iframe.style.display = 'none';
    }
});

toggleFields(document.getElementById('typeSelect').value);
</script>

@endsection
