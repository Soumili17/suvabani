@extends('frontend.layouts.app')

@section('title', 'Member Found | SUVABANI FOUNDATION')

@push('styles')
<style>
/* ---- Single member card ---- */
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

/* ---- Multiple members table ---- */
.multi-box {
    max-width: 800px;
    margin: 60px auto;
    background: white;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    overflow: hidden;
}
.multi-header {
    background: linear-gradient(135deg, #008080, #004d4d);
    color: white;
    padding: 20px 30px;
    text-align: center;
}
.multi-header h3 { margin: 0; font-size: 20px; }
.multi-header p  { margin: 4px 0 0; font-size: 13px; opacity: 0.85; }
.multi-body { padding: 25px 30px; }
.multi-body p.hint {
    color: #555;
    font-size: 14px;
    margin-bottom: 16px;
}
.members-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.members-table th {
    background: #008080;
    color: white;
    padding: 10px 12px;
    text-align: left;
}
.members-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}
.members-table tr:last-child td { border-bottom: none; }
.members-table tr:hover td { background: #f0fdfa; }
.btn-select {
    display: inline-block;
    padding: 6px 16px;
    background: #008080;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-select:hover { background: #006666; color: white; }
.btn-back-multi {
    display: block;
    text-align: center;
    margin-top: 18px;
    color: #008080;
    text-decoration: none;
    font-size: 13px;
}
.btn-back-multi:hover { text-decoration: underline; }

/* Mobile Responsive Table */
@media (max-width: 768px) {

    .multi-body {
        padding: 15px;
    }

    .members-table,
    .members-table thead,
    .members-table tbody,
    .members-table th,
    .members-table td,
    .members-table tr {
        display: block;
        width: 100%;
    }

    .members-table thead {
        display: none;
    }

    .members-table tr {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        margin-bottom: 15px;
        padding: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,.05);
    }

    .members-table td {
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        font-size: 14px;
        text-align: right;
    }

    .members-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #555;
        text-align: left;
        margin-right: 10px;
    }

    .members-table td:last-child {
        justify-content: center;
        padding-top: 12px;
    }

    .btn-select {
        width: 100%;
        text-align: center;
        padding: 10px;
    }
}
</style>
@endpush

@section('content')
<div class="container">

@php
    $isMultiple = isset($members) && $members->count() > 1;
    $isSingle   = !$isMultiple && isset($member);
@endphp

{{-- ========================================================= --}}
{{-- MULTIPLE MEMBERS: show selection table                     --}}
{{-- ========================================================= --}}
@if($isMultiple)
    <div class="multi-box">
        <div class="multi-header">
            <h3>🔍 Multiple Registrations Found</h3>
            <p>SUVABANI FOUNDATION — Please select the membership record you need</p>
        </div>
        <div class="multi-body">
            <p class="hint">We found <strong>{{ $members->count() }}</strong> membership records linked to this mobile number. Choose the one you'd like to download an ID card for.</p>

            <table class="members-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Membership ID</th>
                        <th>Type</th>
                        <th>Registered On</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $i => $m)
                    @php
                        $status = $m->approval_status ?? 'Pending';
                        $cls = match($status) {
                            'Approved' => 'status-approved',
                            'Rejected' => 'status-rejected',
                            default    => 'status-pending',
                        };
                    @endphp
                    <tr>
    <td data-label="#">{{ $i + 1 }}</td>
    <td data-label="Full Name">{{ $m->fullname }}</td>
    <td data-label="Membership ID">{{ $m->membership_id ?? '—' }}</td>
    <td data-label="Type">{{ $m->membertype }}</td>
    <td data-label="Registered On">
        {{ \Carbon\Carbon::parse($m->created_at)->format('d M Y') }}
    </td>
    <td data-label="Status">
        <span class="status-badge {{ $cls }}">{{ $status }}</span>
    </td>
    <td data-label="Action">
        <a href="{{ route('member.download.single', $m->id) }}" class="btn-select">
            Select
        </a>
    </td>
</tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('member.search.page') }}" class="btn-back-multi">← Search again</a>
        </div>
    </div>

{{-- ========================================================= --}}
{{-- SINGLE MEMBER: existing single-card view                   --}}
{{-- ========================================================= --}}
@elseif($isSingle)
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
@endif

</div>
@endsection