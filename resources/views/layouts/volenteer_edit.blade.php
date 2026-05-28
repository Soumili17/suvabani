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

.form-group input{
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

.btn-submit:hover{
    background:#115e59;
}

.preview-img{
    margin-top:10px;
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:6px;
}

.error{
    color:red;
    font-size:14px;
}
</style>

<h2>Edit Volunteer</h2>

<div class="form-container">

<form method="POST" action="{{ route('dashboard.volunteers.update', $volunteer->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<!-- NAME -->
<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $volunteer->name) }}">
    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<!-- DESIGNATION -->
<div class="form-group">
    <label>Designation</label>
    <input type="text" name="designation" value="{{ old('designation', $volunteer->designation) }}" placeholder="e.g. Team Lead, Coordinator">
    @error('designation')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<!-- PROFILE PIC -->
<div class="form-group">
    <label>Profile Picture (JPEG/PNG)</label>
    <input type="file" name="profile_pic" accept="image/jpeg,image/jpg,image/png" onchange="previewImage(event)">
    
    @if($volunteer->profile_pic)
        <p style="margin-top:5px; font-size:13px; color:#555;">Current Profile Picture:</p>
        <img id="preview" class="preview-img" style="display:block;" src="{{ asset('storage/' . $volunteer->profile_pic) }}" alt="Current Profile Picture">
    @else
        <img id="preview" class="preview-img" style="display:none;">
    @endif
    
    @error('profile_pic')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<!-- SUBMIT -->
<button type="submit" class="btn-submit">Update Volunteer</button>

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
