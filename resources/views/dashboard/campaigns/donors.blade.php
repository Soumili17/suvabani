@extends('layouts.dashboard')
@section('content')
<div class="page-heading"><div><h2>{{ $campaign->title }} donors</h2><p>Successful payments for this campaign only.</p></div><a href="{{ route('dashboard.campaigns.index') }}" class="btn-action">Back to campaigns</a></div>
@if($donors->isEmpty())
    <div class="empty-state">No successful donations for this campaign yet.</div>
@else
<div class="table-wrap"><table><thead><tr><th>Donor</th><th>Amount</th><th>Payment status</th><th>Date</th></tr></thead><tbody>
@foreach($donors as $donor)
<tr><td>{{ $donor->anonymous || !$donor->donor_name ? 'Anonymous' : $donor->donor_name }}</td><td>₹{{ number_format($donor->amount, 2) }}</td><td><span class="status status-active">{{ $donor->payment_status }}</span></td><td>{{ optional($donor->donation_date ?: $donor->created_at)->format('d M Y, h:i A') }}</td></tr>
@endforeach
</tbody></table></div>
<div class="pagination-wrap">{{ $donors->links() }}</div>
@endif
@endsection
