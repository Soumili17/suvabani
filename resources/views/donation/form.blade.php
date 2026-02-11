@extends('layouts.app')

@section('title', 'Donate Now')

@section('content')
<div class="donation-container py-5">
    <div class="container">
        <h2 class="text-center mb-4">Donate to SUVABANI FOUNDATION</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('donate.store') }}" method="POST" class="donation-form shadow p-4 rounded bg-white">
            @csrf

            <div class="mb-3">
                <label for="donor_name" class="form-label">Name*</label>
                <input type="text" class="form-control" name="donor_name" id="donor_name" required>
            </div>

            <div class="mb-3">
                <label for="donor_email" class="form-label">Email*</label>
                <input type="email" class="form-control" name="donor_email" id="donor_email" required>
            </div>

            <div class="mb-3">
                <label for="donor_phone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="donor_phone" id="donor_phone">
            </div>

            <div class="mb-3">
                <label for="donor_address" class="form-label">Address</label>
                <textarea class="form-control" name="donor_address" id="donor_address" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount (₹)*</label>
                <input type="number" class="form-control" name="amount" id="amount" min="1" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Donate & Get Form 80C</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.donation-container { background-color: #f9f9f9; }
.donation-form label { font-weight: 500; }
</style>
@endpush
