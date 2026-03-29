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
    display:none;
}

.error{
    color:red;
    font-size:14px;
}
</style>

<h2>Add Volunteer</h2>

<div class="form-container">

<form method="POST" action="{{ route('dashboard.volunteers.store') }}" enctype="multipart/form-data">
@csrf

<!-- NAME -->
<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<!-- EMAIL -->
<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<!-- PHONE -->
<div class="form-group">
    <label>Phone</label>
    <input type="text" name="phone" value="{{ old('phone') }}">
    @error('phone')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<!-- ID CARD -->
<div class="form-group">
    <label>ID Card (JPEG)</label>
    <input type="file" name="id_card" accept="image/jpeg" onchange="previewImage(event)">
    
    <img id="preview" class="preview-img">
    
    @error('id_card')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<!-- SUBMIT -->
<button type="submit" class="btn-submit">Save Volunteer</button>

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