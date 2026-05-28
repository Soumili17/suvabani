@extends('frontend.layouts.app')

@section('title', 'Member Found | SUVABANI FOUNDATION')

@push('styles')
<style>
.card-box {
    max-width: 550px;
    margin: 60px auto;
    background: white;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    overflow: hidden;
}
.card-header-bar {
    background: linear-gradient(135deg, #008080, #004d4d);
    color: white;
    padding: 20px 30px;
    text-align: center;
}
.card-header-bar h3 { margin: 0; font-size: 20px; }
.card-header-bar p  { margin: 4px 0 0; font-size: 13px; opacity: 0.85; }
.card-body-inner { padding: 25px 30px; }
.member-photo {
    text-align: center;
    margin-bottom: 20px;
}
.member-photo img {
    width: 110px;
    height: 110px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #008080;
}
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
}
.info-row:last-child { border-bottom: none; }
.info-label { color: #555; font-weight: 600; }
.info-value { color: #222; }
.status-badge {
    display: inline-block;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}
.status-approved  { background: #d1fae5; color: #065f46; }
.status-pending   { background: #fef3c7; color: #92400e; }
.status-rejected  { background: #fee2e2; color: #991b1b; }
.card-footer-bar {
    padding: 18px 30px;
    background: #f9f9f9;
    text-align: center;
}
.btn-download {
    display: inline-block;
    padding: 12px 30px;
    background: #008080;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    font-size: 15px;
    transition: background 0.2s;
}
.btn-download:hover { background: #006666; color: white; }
.btn-back {
    display: inline-block;
    margin-top: 10px;
    color: #008080;
    text-decoration: none;
    font-size: 13px;
}
.btn-back:hover { text-decoration: underline; }
.alert-warning-box {
    background: #fffbeb;
    border: 1px solid #fcd34d;
    border-radius: 8px;
    padding: 14px 20px;
    color: #92400e;
    font-size: 14px;
    margin-bottom: 10px;
    text-align: center;
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="card-box">

        <div class="card-header-bar">
            <h3>✅ Member Found</h3>
            <p>SUVABANI FOUNDATION — Membership Details</p>
        </div>

        <div class="card-body-inner">

            @if($member->photo)
            <div class="member-photo">
                <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $member->fullname }}">
            </div>
            @endif

            <div class="info-row">
                <span class="info-label">Full Name</span>
                <span class="info-value">{{ $member->fullname }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Membership ID</span>
                <span class="info-value">{{ $member->membership_id ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Mobile</span>
                <span class="info-value">{{ $member->phone }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Member Type</span>
                <span class="info-value">{{ $member->membertype }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Approval Status</span>
                <span class="info-value">
                    @php
                        $status = $member->approval_status;
                        $cls = match($status) {
                            'Approved'  => 'status-approved',
                            'Rejected'  => 'status-rejected',
                            default     => 'status-pending',
                        };
                    @endphp
                    <span class="status-badge {{ $cls }}">{{ $status }}</span>
                </span>
            </div>
            @if($member->approved_at)
            <div class="info-row">
                <span class="info-label">Issued On</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($member->approved_at)->format('d M Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Valid Upto</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($member->approved_at)->addMonths(3)->format('d M Y') }}</span>
            </div>
            @endif
        </div>

        <div class="card-footer-bar">
            @if($member->approval_status === 'Approved')
                <a href="{{ route('membership.download', $member->id) }}" class="btn-download">
                    ⬇ Download ID Card (PDF)
                </a>
            @elseif($member->approval_status === 'Rejected')
                <div class="alert-warning-box">
                    ❌ Your membership application has been <strong>rejected</strong>. Please contact us for more information.
                </div>
            @else
                <div class="alert-warning-box">
                    ⏳ Your membership is <strong>pending approval</strong>. Your ID card will be available for download once the admin approves your application.
                </div>
            @endif
            <br>
            <a href="{{ route('member.search.page') }}" class="btn-back">← Search again</a>
        </div>

    </div>
</div>
@endsection