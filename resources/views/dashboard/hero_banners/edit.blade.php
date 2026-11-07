@extends('layouts.dashboard')
@section('content')
<div class="page-heading"><div><h2>Edit landing page banner</h2><p>Update the banner shown on the homepage.</p></div></div>
<form action="{{ route('dashboard.hero_banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="admin-form">
    @csrf @method('PUT')
    @include('dashboard.hero_banners.form', ['banner' => $banner])
    <button class="btn-action">Save changes</button>
</form>
@endsection
