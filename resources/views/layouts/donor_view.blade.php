@extends('layouts.dashboard')

@section('content')

<style>
.donor-card {
    max-width: 900px;
    margin: 0 auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.donor-card-header {
    background: linear-gradient(135deg, #0f766e, #115e59);
    color: #fff;
    padding: 24px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.donor-card-header h2 {
    margin: 0;
    font-size: 22px;
}

.donor-card-header .receipt-badge {
    background: rgba(255,255,255,0.2);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.donor-card-body {
    padding: 30px;
}

.section-title {
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #0f766e;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 8px;
    margin-bottom: 16px;
    margin-top: 28px;
}

.section-title:first-child {
    margin-top: 0;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px 30px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.detail-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #94a3b8;
    font-weight: 600;
}

.detail-value {
    font-size: 15px;
    color: #1e293b;
    font-weight: 500;
}

.detail-value.mono {
    font-family: monospace;
    font-size: 13px;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 4px;
    word-break: break-all;
}

.badge-status {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
}

.badge-paid    { background: #dcfce7; color: #166534; }
.badge-pending { background: #fef9c3; color: #854d0e; }
.badge-failed  { background: #fee2e2; color: #991b1b; }

.badge-80g-yes { background: #dbeafe; color: #1e40af; }
.badge-80g-no  { background: #f1f5f9; color: #64748b; }

.action-bar {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 18px 30px;
    display: flex;
    gap: 10px;
}

.btn-back {
    padding: 8px 20px;
    background: #64748b;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}
.btn-back:hover { background: #475569; color: #fff; }

.btn-edit {
    padding: 8px 20px;
    background: #0f766e;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}
.btn-edit:hover { background: #115e59; color: #fff; }

.btn-80g {
    padding: 8px 20px;
    background: #1d4ed8;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}
.btn-80g:hover { background: #1e40af; color: #fff; }

@media (max-width: 640px) {
    .detail-grid { grid-template-columns: 1fr; }
    .donor-card-header { flex-direction: column; gap: 10px; text-align: center; }
    .action-bar { flex-direction: column; }
}
</style>

<div class="donor-card">

    {{-- HEADER --}}
    <div class="donor-card-header">
        <h2>🧾 Donor Details</h2>
        <span class="receipt-badge">{{ $donor->receipt_number ?? 'N/A' }}</span>
    </div>

    <div class="donor-card-body">

        {{-- PERSONAL INFO --}}
        <div class="section-title">👤 Personal Information</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Full Name</span>
                <span class="detail-value">{{ $donor->donor_name ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $donor->donor_email ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Phone</span>
                <span class="detail-value">{{ $donor->donor_phone ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">PAN Number</span>
                <span class="detail-value mono">{{ $donor->donor_pan ? strtoupper($donor->donor_pan) : '—' }}</span>
            </div>
        </div>

        {{-- ADDRESS --}}
        <div class="section-title">🏠 Address</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Address</span>
                <span class="detail-value">{{ $donor->donor_address ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">City</span>
                <span class="detail-value">{{ $donor->donor_city ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">State</span>
                <span class="detail-value">{{ $donor->donor_state ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Pincode</span>
                <span class="detail-value">{{ $donor->donor_pincode ?? '—' }}</span>
            </div>
        </div>

        {{-- DONATION DETAILS --}}
        <div class="section-title">💰 Donation Details</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Amount</span>
                <span class="detail-value" style="font-size:20px; color:#0f766e; font-weight:700;">
                    ₹{{ number_format($donor->amount, 2) }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Donation Purpose</span>
                <span class="detail-value">{{ $donor->donation_purpose ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Donation Date</span>
                <span class="detail-value">
                    {{ $donor->donation_date ? date('d M Y, h:i A', strtotime($donor->donation_date)) : '—' }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Receipt Number</span>
                <span class="detail-value mono">{{ $donor->receipt_number ?? '—' }}</span>
            </div>
        </div>

        {{-- 80G & PAN --}}
        <div class="section-title">📄 80G Certificate</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">80G Required</span>
                <span class="detail-value">
                    @if($donor->need_80g)
                        <span class="badge-status badge-80g-yes">✅ Yes — Requires 80G</span>
                    @else
                        <span class="badge-status badge-80g-no">❌ No</span>
                    @endif
                </span>
            </div>
            @if($donor->need_80g)
            <div class="detail-item">
                <span class="detail-label">Download 80G Certificate</span>
                <span class="detail-value">
                    <a href="{{ route('80g.download', $donor->id) }}" class="btn-80g">⬇ Download 80G PDF</a>
                </span>
            </div>
            @endif
        </div>

        {{-- PAYMENT INFO --}}
        <div class="section-title">💳 Payment Information</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Payment Status</span>
                <span class="detail-value">
                    @if($donor->payment_status === 'Paid')
                        <span class="badge-status badge-paid">✅ Paid</span>
                    @elseif($donor->payment_status === 'Pending')
                        <span class="badge-status badge-pending">⏳ Pending</span>
                    @else
                        <span class="badge-status badge-failed">❌ Failed</span>
                    @endif
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Razorpay Order ID</span>
                <span class="detail-value mono">{{ $donor->razorpay_order_id ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Razorpay Payment ID</span>
                <span class="detail-value mono">{{ $donor->razorpay_payment_id ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Donation Created</span>
                <span class="detail-value">{{ date('d M Y, h:i A', strtotime($donor->created_at)) }}</span>
            </div>
        </div>

    </div>{{-- end body --}}

    {{-- ACTION BAR --}}
    <div class="action-bar">
        <a href="{{ route('dashboard.donors') }}" class="btn-back">← Back to List</a>
        <a href="{{ route('dashboard.donors.edit', $donor->id) }}" class="btn-edit">✏️ Edit Donor</a>
    </div>

</div>

@endsection