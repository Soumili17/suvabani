@extends('frontend.layouts.app')

@section('title', 'Download Membership Card | SUVABANI FOUNDATION')

@push('styles')
<style>
.container-box { max-width:500px; margin:auto; background:white; padding:30px; border-radius:10px; box-shadow:0 10px 25px rgba(0,0,0,0.1); }
h2 { text-align:center; color:#008080; }
.btn-search { width:100%; padding:12px; margin-top:15px; background:#008080; color:white; border:none; border-radius:6px; cursor:pointer; font-size:16px; }
.btn-search:hover { background:#006666; }
.error { color:red; margin-top:10px; }
.success { color:green; margin-top:10px; }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="container-box">
        <h2>Download Membership Card</h2>
        <form method="POST" action="{{ url('/membership/search') }}" class="mt-4">
        @csrf
        <div class="mb-3">
            <label class="fw-bold mb-2">Enter Registered Mobile Number</label>
            <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number">
        </div>
        <button type="submit" class="btn-search">Search Member</button>
        </form>
        @if ($errors->any())
        <div class="error text-center mt-3">{{ $errors->first() }}</div>
        @endif
    </div>
</div>
@endsection