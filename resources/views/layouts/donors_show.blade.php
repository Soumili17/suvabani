@extends('layouts.dashboard')

@section('content')

<style>
table{ width:100%; border-collapse:collapse; margin-top:20px; } th,td{ border:1px solid #ddd; padding:10px; text-align:left; } th{ background:#0f766e; color:white; } .btn-action{ padding:6px 12px; background:#0f766e; color:white; border-radius:6px; text-decoration:none; margin-right:5px; border:none; cursor:pointer; } .btn-action:hover{ background:#115e59; } .status-paid{ color:green; font-weight:bold; } .status-pending{ color:orange; font-weight:bold; } .status-failed{ color:red; font-weight:bold; } .page-title{ font-size:24px; margin-bottom:10px; } /* ================= MOBILE RESPONSIVE ================= */ @media (max-width:768px){ /* Make table scrollable */ table{ display:block; overflow-x:auto; white-space:nowrap; } th,td{ padding:8px; font-size:13px; } /* Buttons stack better */ .btn-action{ display:inline-block; margin-bottom:5px; font-size:12px; padding:5px 10px; } /* Title adjust */ .page-title{ font-size:18px; text-align:center; } }
</style>

<h2 class="page-title">All Donations</h2>

{{-- FILTER FORM (always visible) --}}
<form method="GET" action="{{ route('dashboard.donors') }}" style="margin-bottom:20px; display:flex; flex-wrap:wrap; gap:10px; align-items:center; background:#f8fafc; padding:15px; border-radius:8px; border:1px solid #e2e8f0;">

    {{-- Search --}}
    <input type="text"
        name="search"
        placeholder="🔍 Search name, email or phone"
        value="{{ request('search') }}"
        style="padding:8px 12px; width:230px; border:1px solid #ccc; border-radius:6px; font-size:14px;">

    {{-- 80G Filter --}}
    <select name="need_80g" style="padding:8px 12px; border:1px solid #ccc; border-radius:6px; font-size:14px; background:#fff;">
        <option value="">📄 All 80G Status</option>
        <option value="1" {{ request('need_80g') === '1' ? 'selected' : '' }}>✅ Yes (80G Required)</option>
        <option value="0" {{ request('need_80g') === '0' ? 'selected' : '' }}>❌ No 80G</option>
    </select>

    {{-- Payment Status Filter --}}
    <select name="payment_status" style="padding:8px 12px; border:1px solid #ccc; border-radius:6px; font-size:14px; background:#fff;">
        <option value="">💳 All Payment Status</option>
        <option value="Paid"    {{ request('payment_status') === 'Paid'    ? 'selected' : '' }}>✅ Paid</option>
        <option value="Pending" {{ request('payment_status') === 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
        <option value="Failed"  {{ request('payment_status') === 'Failed'  ? 'selected' : '' }}>❌ Failed</option>
    </select>

    {{-- Donation Purpose Filter --}}
    @if(isset($purposes) && $purposes->isNotEmpty())
    <select name="donation_purpose" style="padding:8px 12px; border:1px solid #ccc; border-radius:6px; font-size:14px; background:#fff;">
        <option value="">🎯 All Purposes</option>
        @foreach($purposes as $purpose)
            <option value="{{ $purpose }}" {{ request('donation_purpose') === $purpose ? 'selected' : '' }}>{{ $purpose }}</option>
        @endforeach
    </select>
    @endif

    <button type="submit" class="btn-action" style="padding:8px 18px;">
        Filter
    </button>

    <a href="{{ route('dashboard.donors') }}" class="btn-action" style="padding:8px 18px; background:#6c757d;">
        Reset
    </a>

</form>

@if($donors->isEmpty())
<p style="color:#666; padding:15px; background:#fff3cd; border-radius:6px; border-left:4px solid #ffc107;">
    ⚠️ No donors found matching the selected filters.
</p>
@else
<table>

<tr>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Address</th>
<th>Amount</th>
<th>Purpose</th>
<th>80G</th>
<th>Status</th>
<th>Receipt</th>
<th>Date</th>
<th>Action</th>
</tr>
@foreach($donors as $donor)

<tr>

<td>{{ $donor->name }}</td>

<td>{{ $donor->email }}</td>

<td>{{ $donor->phone }}</td>

<td>{{ $donor->address }}</td>

<td>₹{{ number_format($donor->amount,2) }}</td>

<td>{{ $donor->donation_purpose }}</td>

<td>
@if($donor->need_80g)
Yes
@else
No
@endif
</td>

<td>
@if($donor->payment_status == 'Paid')
<span class="status-paid">Paid</span>

@elseif($donor->payment_status == 'Pending')
<span class="status-pending">Pending</span>

@else
<span class="status-failed">Failed</span>
@endif
</td>

<td>{{ $donor->receipt_number }}</td>

<td>{{ date('d-m-Y', strtotime($donor->donation_date)) }}</td>

<td>

<a href="{{ route('dashboard.donors.view',$donor->id) }}" class="btn-action">
View
</a>

<a href="{{ route('dashboard.donors.edit',$donor->id) }}" class="btn-action">
Edit
</a>

<form action="{{ route('dashboard.donors.delete',$donor->id) }}" 
method="POST" 
style="display:inline;">

@csrf
@method('DELETE')

<button type="submit"
onclick="return confirm('Delete this donor?')"
class="btn-action">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</table>
<div style="margin-top:20px;">
{{ $donors->links() }}
</div>
@endif

@endsection