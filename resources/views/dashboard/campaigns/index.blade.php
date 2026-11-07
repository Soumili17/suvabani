@extends('layouts.dashboard')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap;">
    <h2 style="margin:0; color:#0f9d94;">Campaigns</h2>
    <a href="{{ route('dashboard.campaigns.create') }}" class="btn-action">Create campaign</a>
</div>

@if ($campaigns->isEmpty())
    <p style="margin-top:20px; padding:16px; background:#f4fbfb; border-radius:8px;">
        No campaigns found. Create a campaign to get started.
    </p>
@else
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Raised / donors</th>
                    <th>Homepage</th>
                    <th>Display order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campaigns as $campaign)
                    <tr>
                        <td>{{ $campaign->title }}</td>
                        <td>{{ $campaign->category?->name ?? '—' }}</td>
                        <td>{{ ucfirst($campaign->status) }}</td>
                        <td>₹{{ number_format($campaign->totalDonations() / 100, 0) }} / {{ $campaign->donorCount() }}</td>
                        <td>
                            <form action="{{ route('dashboard.campaigns.feature', $campaign) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-action" style="border:0; cursor:pointer; background:#6b46c1;">
                                    {{ $campaign->is_featured ? 'Unfeature' : 'Feature' }}
                                </button>
                            </form>
                        </td>
                        <td>{{ $campaign->display_order }}</td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('dashboard.campaigns.edit', $campaign) }}" class="btn-action">Edit</a>
                            <a href="{{ route('dashboard.campaigns.updates', $campaign) }}" class="btn-action">Updates</a>
                            <a href="{{ route('dashboard.campaigns.donors', $campaign) }}" class="btn-action">Donors</a>
                            @if ($campaign->status === 'published')
                                <form action="{{ route('dashboard.campaigns.unpublish', $campaign) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action" style="border:0; cursor:pointer; background:#777;">Unpublish</button>
                                </form>
                            @else
                                <form action="{{ route('dashboard.campaigns.publish', $campaign) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action" style="border:0; cursor:pointer;">Publish</button>
                                </form>
                            @endif
                            <form action="{{ route('dashboard.campaigns.destroy', $campaign) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this campaign?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action" style="border:0; cursor:pointer; background:#b42318;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $campaigns->links() }}
    </div>
@endif
@endsection
