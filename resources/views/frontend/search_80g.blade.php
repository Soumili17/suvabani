@extends('frontend.layouts.app')

@section('title', 'Find 80G Certificate | SUVABANI FOUNDATION')

@push('styles')
<style>
.wrapper{ padding:60px 20px; }
.card-box{ max-width:450px; margin:auto; background:white; padding:40px; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.08); }
.btn-search { width:100%; padding:14px; border:none; border-radius:8px; background:linear-gradient(135deg,#0f766e,#14b8a6); color:white; font-weight:bold; cursor:pointer; }
</style>
@endpush

@section('content')
<div class="wrapper my-5">
<div class="card-box">
<h2 style="text-align:center;color:#0f766e;" class="mb-4">Find 80G Certificate</h2>
@if ($errors->any())
<div class="text-danger mb-3">{{ $errors->first() }}</div>
@endif
<form method="POST" action="{{ route('80g.search') }}">
@csrf
<input type="text" name="mobile" class="form-control mb-3 p-3 border-secondary" placeholder="Enter Mobile Number">
<button type="submit" class="btn-search">Search Donations</button>
</form>
</div>
</div>
@endsection