@extends('layouts.dashboard')

@section('content')

<style>
.form-container{
    max-width:600px;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
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

.btn-submit{
    background:#0f766e;
    color:white;
    padding:10px 20px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.preview-img{
    margin-top:10px;
    width:150px;
    height:150px;
    object-fit:cover;
    display:none;
    border-radius:6px;
}

.error{
    color:red;
    font-size:14px;
}
</style>

<h2>Upload Gallery Image</h2>

<div class="form-container">

<form method="POST" action="{{ route('dashboard.gallery.store') }}" enctype="multipart/form-data">
@csrf

<!-- TITLE -->
<div class="form-group">
    <label>Title</label>
    <input type="text" name="title" value="{{ old('title') }}">
    @error('title') <div class="error">{{ $message }}</div> @enderror
</div>

<!-- CATEGORY -->
<div class="form-group">
    <label>Category</label>
    <select name="category">
        <option value="">-- Select Category --</option>
        <option value="Child Welfare">Child Welfare</option>
        <option value="Women Empowerment">Women Empowerment</option>
        <option value="Healthcare Support">Healthcare Support</option>
        <option value="Education for All">Education for All</option>
    </select>
    @error('category') <div class="error">{{ $message }}</div> @enderror
</div>

<!-- IMAGE -->
<div class="form-group">
    <label>Upload Image</label>
    <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
    
    <img id="preview" class="preview-img">

    @error('image') <div class="error">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn-submit">Upload</button>

</form>

</div>

<script>
function previewImage(event){
    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
}
</script>

@endsection