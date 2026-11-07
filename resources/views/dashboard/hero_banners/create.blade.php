@extends('layouts.dashboard')
@section('content')
<div class="page-heading"><div><h2>Add landing page banner</h2><p>Upload an image and set the text and action.</p></div></div>
<form action="{{ route('dashboard.hero_banners.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
    @csrf
    @include('dashboard.hero_banners.form')
    <button class="btn-action">Save banner</button>
</form>
@endsection
