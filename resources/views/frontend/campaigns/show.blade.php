@extends('frontend.layouts.app')

@section('title', $campaign->title . ' | SUVABANI FOUNDATION')

@push('styles')
<style>
    .fundraiser-page { background:#f7faff; padding:32px 0 64px; }
    .fundraiser-card { background:#fff; border:0; border-radius:18px; box-shadow:0 8px 28px rgba(0,43,92,.09); }
    .fundraiser-cover { width:100%; height:380px; object-fit:cover; border-radius:18px; }
    .fundraiser-sidebar { position:sticky; top:20px; }
    .fundraiser-progress { height:10px; }
    .campaign-media-carousel,
    .campaign-media-carousel img { height:380px; }
    .campaign-media-carousel img { width:100%; object-fit:cover; border-radius:18px; }
    .campaign-media-carousel video { width:100%; height:100%; object-fit:cover; border-radius:18px; }
    .campaign-media-thumbnails { display:flex; gap:8px; overflow-x:auto; padding:2px 0 4px; }
    .campaign-media-thumbnail { flex:0 0 78px; height:56px; padding:0; border:2px solid transparent; border-radius:8px; overflow:hidden; background:#eaf2fb; }
    .campaign-media-thumbnail.active { border-color:#003f88; }
    .campaign-media-thumbnail img { width:100%; height:100%; object-fit:cover; }
    .campaign-media-thumbnail video { width:100%; height:100%; object-fit:cover; pointer-events:none; }
    .campaign-media-thumbnail .video-icon { position:absolute; inset:0; display:grid; place-items:center; color:#fff; background:rgba(0,43,92,.35); }
    .campaign-action { background:#003f88; border-color:#003f88; color:#fff; }
    .campaign-action:hover, .campaign-action:focus { background:#002b5c; border-color:#002b5c; color:#fff; }
    .share-fallback[hidden] { display:none !important; }
    .fundraiser-tabs .nav-link { color:#31577d; border:0; border-bottom:3px solid transparent; }
    .fundraiser-tabs .nav-link.active { color:#003f88; border-bottom-color:#003f88; background:transparent; }
    @media (max-width:767px) { .fundraiser-cover { height:240px; } .fundraiser-sidebar { position:static; } }
</style>
@endpush

@section('content')
<main class="fundraiser-page">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('campaigns.index') }}" class="text-decoration-none">&larr; All campaigns</a>
            <button type="button" class="btn btn-outline-primary btn-sm" id="shareCampaign">Share campaign</button>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <article class="fundraiser-card p-3 p-md-4">
                    @php
                        $campaignSlides = $campaign->media
                            ->map(fn ($media) => [
                                'path' => $media->file_path,
                                'type' => $media->media_type,
                                'alt' => $media->caption ?: $campaign->title,
                            ]);
                        if ($campaign->cover_media_path) {
                            $campaignSlides->prepend(['path' => $campaign->cover_media_path, 'type' => 'image', 'alt' => $campaign->title]);
                        }
                    @endphp
                    @if($campaignSlides->isNotEmpty())
                        <div id="campaignDetailCarousel" class="carousel slide campaign-media-carousel mb-4" data-bs-ride="carousel">
                            @if($campaignSlides->count() > 1)
                                <div class="carousel-indicators">
                                    @foreach($campaignSlides as $slide)
                                        <button type="button" data-bs-target="#campaignDetailCarousel"
                                                data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"
                                                aria-label="Slide {{ $loop->iteration }}"></button>
                                    @endforeach
                                </div>
                            @endif
                            <div class="carousel-inner h-100">
                                @foreach($campaignSlides as $slide)
                                    <div class="carousel-item h-100 {{ $loop->first ? 'active' : '' }}">
                                        @if($slide['type'] === 'video')
                                            <video src="{{ asset('storage/'.$slide['path']) }}" controls preload="metadata"></video>
                                        @else
                                            <img src="{{ asset('storage/'.$slide['path']) }}" alt="{{ $slide['alt'] }}">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if($campaignSlides->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#campaignDetailCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#campaignDetailCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span><span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                        @if($campaignSlides->count() > 1)
                            <div class="campaign-media-thumbnails" aria-label="Campaign media thumbnails">
                                @foreach($campaignSlides as $slide)
                                    <button type="button" class="campaign-media-thumbnail position-relative {{ $loop->first ? 'active' : '' }}"
                                            data-bs-target="#campaignDetailCarousel" data-bs-slide-to="{{ $loop->index }}"
                                            aria-label="Show media {{ $loop->iteration }}">
                                        @if($slide['type'] === 'video')
                                            <video src="{{ asset('storage/'.$slide['path']) }}" muted preload="metadata"></video>
                                            <span class="video-icon"><i class="fas fa-play"></i></span>
                                        @else
                                            <img src="{{ asset('storage/'.$slide['path']) }}" alt="">
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    @endif
                    <div class="share-fallback border rounded p-3 mt-3" hidden id="showShareFallback">
                            <label for="showShareUrl" class="form-label fw-semibold">Campaign link</label>
                            <div class="input-group">
                                <input id="showShareUrl" class="form-control" readonly>
                                <button type="button" class="btn btn-outline-primary" id="showCopyShareUrl">Copy link</button>
                            </div>
                            <small id="showCopyShareFeedback" class="text-success d-block mt-2" role="status"></small>
                    </div>
                    <div class="small text-uppercase text-secondary mb-2">
                        {{ $campaign->category?->name ?? 'Community project' }}
                        @if($campaign->location) · {{ $campaign->location }} @endif
                    </div>
                    <h1 class="h2 text-primary">{{ $campaign->title }}</h1>
                    @if($campaign->beneficiary_name)
                        <p class="text-muted mb-3">Supporting {{ $campaign->beneficiary_name }}</p>
                    @endif
                    @if($campaign->short_description)
                        <p class="lead">{{ $campaign->short_description }}</p>
                    @endif

                    <ul class="nav nav-tabs fundraiser-tabs mb-4" role="tablist">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#story" type="button">About</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#updates" type="button">Updates</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#supporters" type="button">Supporters</button></li>
                    </ul>

                    <div class="tab-content">
                        <section class="tab-pane fade show active" id="story">
                            @foreach([
                                'story' => 'The story',
                                'why_funding' => 'Why support this project?',
                                'fund_utilization' => 'How funds will be used',
                                'milestones' => 'Milestones',
                            ] as $field => $heading)
                                @if($campaign->{$field})
                                    <h2 class="h5 text-primary mt-4">{{ $heading }}</h2>
                                    <div style="white-space:pre-line;">{{ $campaign->{$field} }}</div>
                                @endif
                            @endforeach
                            @if(!$campaign->story && !$campaign->description)
                                <p class="text-muted">Project details will be updated soon.</p>
                            @endif
                            @if($campaign->description)
                                <div class="mt-4" style="white-space:pre-line;">{{ $campaign->description }}</div>
                            @endif
                        </section>
                        <section class="tab-pane fade" id="updates">
                            @forelse($campaign->updates as $update)
                                <article class="border-bottom pb-3 mb-3">
                                    <h3 class="h6">{{ $update->title }}</h3>
                                    <small class="text-muted">{{ $update->published_at?->format('d M Y') }}</small>
                                    <p class="mb-0 mt-2" style="white-space:pre-line;">{{ $update->description }}</p>
                                    @if($update->image_path)
                                        <img src="{{ asset('storage/'.$update->image_path) }}" alt="{{ $update->title }}" class="img-fluid rounded mt-2">
                                    @endif
                                </article>
                            @empty
                                <p class="text-muted">No updates published yet.</p>
                            @endforelse
                        </section>
                        <section class="tab-pane fade" id="supporters">
                            @php($supporters = $campaign->donations()->whereIn('payment_status', ['Paid', 'paid'])->latest()->take(10)->get())
                            @forelse($supporters as $supporter)
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <span>{{ $supporter->donor_name ?: 'Anonymous supporter' }}</span>
                                    <strong>₹{{ number_format($supporter->amount, 0) }}</strong>
                                </div>
                            @empty
                                <p class="text-muted">Be the first to support this project.</p>
                            @endforelse
                        </section>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                @php($raised = $campaign->totalDonations())
                @php($progress = $campaign->progressPercentage())
                <aside class="fundraiser-card fundraiser-sidebar p-4">
                    <div class="d-flex justify-content-between align-items-end">
                        <div><div class="h3 mb-0 text-primary">₹{{ number_format($raised / 100, 0) }}</div><small class="text-muted">raised</small></div>
                        <div class="text-end"><strong>₹{{ number_format($campaign->goal_amount / 100, 0) }}</strong><br><small class="text-muted">goal</small></div>
                    </div>
                    <div class="progress fundraiser-progress my-3">
                        <div class="progress-bar bg-success" style="width:{{ $progress }}%"></div>
                    </div>
                    <div class="small text-muted mb-4">{{ number_format($progress, 1) }}% funded · {{ $campaign->donorCount() }} supporters</div>
                    <a href="{{ route('donate', ['campaign' => $campaign->slug]) }}" class="btn campaign-action btn-lg w-100">Donate now</a>
                    @if($campaign->end_date)
                        <p class="small text-center text-muted mt-3 mb-0">Fundraising ends {{ $campaign->end_date->format('d M Y') }}</p>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.getElementById('shareCampaign')?.addEventListener('click', async function () {
    const shareData = { title: @json($campaign->title), url: window.location.href };
    if (navigator.share) {
        try {
            await navigator.share(shareData);
        } catch (error) {
            if (error.name !== 'AbortError') console.error('Campaign sharing failed:', error);
        }
    } else {
        document.getElementById('showShareUrl').value = window.location.href;
        document.getElementById('showShareFallback').hidden = false;
    }
});
document.getElementById('showCopyShareUrl')?.addEventListener('click', async () => {
    await navigator.clipboard.writeText(document.getElementById('showShareUrl').value);
    document.getElementById('showCopyShareFeedback').textContent = 'Link copied successfully.';
});

document.getElementById('campaignDetailCarousel')?.addEventListener('slid.bs.carousel', event => {
    document.querySelectorAll('.campaign-media-thumbnail').forEach((thumbnail, index) => {
        thumbnail.classList.toggle('active', index === event.to);
    });
});
</script>
@endpush
