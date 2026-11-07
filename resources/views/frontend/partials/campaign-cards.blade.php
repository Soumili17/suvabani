@push('styles')
<style>
    .campaigns-home { padding: 1.5rem 0 2.25rem; }
    .campaigns-home-card { border:0; border-radius:16px; overflow:hidden; background:#fff; box-shadow:0 6px 20px rgba(0,43,92,.12); transition:transform .2s ease, box-shadow .2s ease; }
    .campaigns-home-card:hover { transform:translateY(-4px); box-shadow:0 12px 28px rgba(0,43,92,.18); }
    .campaigns-home-media, .campaigns-home-media img { height:215px; }
    .campaigns-home-media { background:#eaf2fb; }
    .campaigns-home-media img { width:100%; object-fit:cover; }
    .campaigns-home-badge { position:absolute; z-index:2; top:0; right:0; padding:.55rem .8rem; border-radius:0 0 0 16px; background:#f74355; color:#fff; font-size:.75rem; font-weight:700; }
    .campaigns-home-card .card-body { padding:1.1rem 1.15rem 1rem; }
    .campaigns-home-card h3 { color:#002b5c; line-height:1.3; }
    .campaigns-home-progress { height:9px; background:#eee; }
    .campaigns-home-progress .progress-bar { background:#f74355; }
    .campaigns-home-metrics { border-bottom:1px solid #ddd; }
    .campaigns-home-metric { border-right:1px solid #ddd; }
    .campaigns-home-metric:last-child { border-right:0; }
    .campaigns-home-metric-icon { width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; background:#ffe8eb; color:#f74355; }
    .campaigns-home-share { color:#002b5c; border-color:#d6e0eb; }
    .campaigns-home-donate { background:#003f88; border-color:#003f88; color:#fff; border-radius:10px; box-shadow:0 4px 0 #001d3d; font-weight:700; }
    .campaigns-home-donate:hover, .campaigns-home-donate:focus { background:#002b5c; border-color:#002b5c; color:#fff; }
</style>
@endpush

<section class="campaigns-home container" id="campaigns">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Support a Cause</h2>
            <p class="mb-0 text-muted">Help make a meaningful difference today.</p>
        </div>
        <a href="{{ route('campaigns.index') }}" class="btn btn-outline-primary rounded-pill">View all</a>
    </div>
    <div class="row g-4">
        @foreach($featuredCampaigns as $campaign)
            @php
                $raised = $campaign->totalDonations();
                $progress = $campaign->progressPercentage();
                $imageCount = $campaign->media->count() + ($campaign->cover_media_path ? 1 : 0);
            @endphp
            <div class="col-md-6 col-lg-4">
                <article class="card h-100 campaigns-home-card"
                         data-campaign-url="{{ route('campaigns.show', $campaign->slug) }}"
                         role="link" tabindex="0"
                         aria-label="View campaign: {{ $campaign->title }}">
                    @if($imageCount)
                        <div id="campaignCarousel{{ $campaign->id }}" class="carousel slide campaigns-home-media position-relative" data-bs-ride="carousel">
                            <span class="campaigns-home-badge">Tax Benefit</span>
                            @if($imageCount > 1)
                                <div class="carousel-indicators">
                                    @if($campaign->cover_media_path)
                                        <button type="button" data-bs-target="#campaignCarousel{{ $campaign->id }}" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                                    @endif
                                    @foreach($campaign->media as $media)
                                        <button type="button" data-bs-target="#campaignCarousel{{ $campaign->id }}" data-bs-slide-to="{{ $loop->index + ($campaign->cover_media_path ? 1 : 0) }}" class="{{ !$campaign->cover_media_path && $loop->first ? 'active' : '' }}" aria-label="Slide {{ $loop->iteration }}"></button>
                                    @endforeach
                                </div>
                            @endif
                            <div class="carousel-inner h-100">
                                @if($campaign->cover_media_path)
                                    <div class="carousel-item active h-100"><img src="{{ asset('storage/'.$campaign->cover_media_path) }}" alt="{{ $campaign->title }}"></div>
                                @endif
                                @foreach($campaign->media as $media)
                                    <div class="carousel-item h-100 {{ !$campaign->cover_media_path && $loop->first ? 'active' : '' }}"><img src="{{ asset('storage/'.$media->file_path) }}" alt="{{ $media->caption ?: $campaign->title }}"></div>
                                @endforeach
                            </div>
                            @if($imageCount > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#campaignCarousel{{ $campaign->id }}" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span></button>
                                <button class="carousel-control-next" type="button" data-bs-target="#campaignCarousel{{ $campaign->id }}" data-bs-slide="next"><span class="carousel-control-next-icon"></span><span class="visually-hidden">Next</span></button>
                            @endif
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 mb-2">{{ Str::limit($campaign->title, 72) }}</h3>
                        @if($campaign->short_description)<p class="text-muted small mb-3">{{ Str::limit($campaign->short_description, 110) }}</p>@endif
                        <div class="progress campaigns-home-progress mb-2" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width:{{ $progress }}%"></div></div>
                        <div class="row g-0 campaigns-home-metrics py-3 mb-3">
                            <div class="col-4 campaigns-home-metric"><span class="campaigns-home-metric-icon"><i class="fas fa-bullseye"></i></span><small class="d-block text-muted mt-1">Goal</small><strong class="small">₹{{ number_format($campaign->goal_amount / 100, 0) }}</strong></div>
                            <div class="col-4 campaigns-home-metric ps-2 campaigns-home-metric"><span class="campaigns-home-metric-icon"><i class="fas fa-rupee-sign"></i></span><small class="d-block text-muted mt-1">Raised</small><strong class="small">₹{{ number_format($raised / 100, 0) }}</strong></div>
                            <div class="col-4 campaigns-home-metric ps-2"><span class="campaigns-home-metric-icon"><i class="fas fa-users"></i></span><small class="d-block text-muted mt-1">Donors</small><strong class="small">{{ $campaign->donorCount() }}</strong></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center gap-2 mt-auto">
                            <button type="button" class="btn btn-outline-secondary btn-sm campaigns-home-share" data-share-url="{{ route('campaigns.show', $campaign->slug) }}" data-share-title="{{ $campaign->title }}"><i class="fas fa-share-alt me-1"></i>Share</button>
                            <a href="{{ route('donate', ['campaign' => $campaign->slug]) }}" class="btn campaigns-home-donate px-3 py-2">Donate Now</a>
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
</section>

<div class="modal fade" id="campaignShareModal" tabindex="-1" aria-labelledby="campaignShareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="campaignShareModalLabel">Share campaign</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="campaignShareUrl" class="form-label">Campaign link</label>
                <div class="input-group">
                    <input id="campaignShareUrl" class="form-control" readonly>
                    <button type="button" class="btn btn-outline-primary" id="campaignCopyShareUrl">Copy link</button>
                </div>
                <small id="campaignCopyShareFeedback" class="text-success d-block mt-2" role="status"></small>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.campaigns-home-share').forEach(button => {
    button.addEventListener('click', async event => {
        event.stopPropagation();
        const url = button.dataset.shareUrl;
        const title = button.dataset.shareTitle || document.title;
        if (navigator.share) {
            try {
                await navigator.share({ title, text: title, url });
            } catch (error) {
                if (error.name !== 'AbortError') console.error('Campaign sharing failed:', error);
            }
            return;
        }

        document.getElementById('campaignShareUrl').value = url;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('campaignShareModal')).show();
    });
});

document.querySelectorAll('.campaigns-home-card').forEach(card => {
    const openCampaign = () => window.location.href = card.dataset.campaignUrl;

    card.addEventListener('click', event => {
        if (!event.target.closest('button, a')) {
            openCampaign();
        }
    });
    card.addEventListener('keydown', event => {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            openCampaign();
        }
    });
});

document.getElementById('campaignCopyShareUrl')?.addEventListener('click', async () => {
    await navigator.clipboard.writeText(document.getElementById('campaignShareUrl').value);
    document.getElementById('campaignCopyShareFeedback').textContent = 'Link copied successfully.';
});
</script>
@endpush
