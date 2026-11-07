@extends('frontend.layouts.app')

@section('title', 'Campaigns | SUVABANI FOUNDATION')

@push('styles')
<style>
    .campaigns-page { padding: 48px 0 64px; }
    .campaigns-heading { margin-bottom: 32px; text-align: center; }
    .campaigns-heading h1 { color: #003f88; font-weight: 700; }
    .campaign-card { height: 100%; overflow: hidden; border: 0; border-radius: 14px; box-shadow: 0 6px 22px rgba(0, 43, 92, .1); }
    .campaign-card img { width: 100%; height: 220px; object-fit: cover; }
    .campaign-card .card-body { display: flex; flex-direction: column; align-items: flex-start; }
    .campaign-card h2 { color: #003f88; font-size: 1.25rem; }
    .campaign-card .btn { margin-top: auto; background: #003f88; border-color: #003f88; }
    .campaign-empty { padding: 48px 24px; border-radius: 14px; background: #fff; text-align: center; }
</style>
@endpush

@section('content')
<section class="campaigns-page">
    <div class="container">
        <header class="campaigns-heading">
            <h1>Our Campaigns</h1>
            <p class="mb-0">See the initiatives making a difference in our community.</p>
        </header>

        @if ($campaigns->isEmpty())
            <div class="campaign-empty">
                <h2 class="h4">No campaigns are available right now</h2>
                <p class="mb-0">Please check back soon to see our latest initiatives.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($campaigns as $campaign)
                    <div class="col-md-6 col-lg-4">
                        <article class="card campaign-card">
                            @if ($campaign->cover_media_path)
                                <img src="{{ asset('storage/' . $campaign->cover_media_path) }}" alt="{{ $campaign->title }}">
                            @endif
                            <div class="card-body p-4">
                                @if ($campaign->category)
                                    <p class="small text-uppercase text-secondary mb-2">{{ $campaign->category->name }}</p>
                                @endif
                                <h2 class="card-title">{{ $campaign->title }}</h2>
                                @if ($campaign->short_description)
                                    <p class="card-text">{{ $campaign->short_description }}</p>
                                @endif
                                @if ($campaign->goal_amount)
                                    @php($raised = $campaign->totalDonations())
                                    <div class="progress w-100 mb-2" style="height:8px;">
                                        <div class="progress-bar bg-success" style="width:{{ $campaign->progressPercentage() }}%"></div>
                                    </div>
                                    <p class="small text-secondary mb-3">
                                        ₹{{ number_format($raised / 100, 0) }} raised of ₹{{ number_format($campaign->goal_amount / 100, 0) }}
                                        · {{ $campaign->donorCount() }} supporters
                                    </p>
                                @endif
                                <a class="btn btn-primary" href="{{ route('campaigns.show', $campaign->slug) }}">Learn more</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
