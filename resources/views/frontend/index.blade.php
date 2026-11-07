@extends('frontend.layouts.app')

@section('title', 'SUVABANI FOUNDATION - Home')

@section('content')

<!-- HERO SLIDER -->
<section class="slider">
    <div class="slides">

        @forelse($heroBanners as $banner)
            <div class="slide {{ $loop->first ? 'active' : '' }}"
                 style="background-image:url('{{ asset('storage/'.$banner->image_path) }}');">
                <div class="content">
                    <h1>{{ $banner->title }}</h1>
                    <hr>
                    <p>{{ $banner->subtitle }}</p>
                    @if($banner->button_text && $banner->button_url)
                        <div class="hero-btns">
                            <a href="{{ $banner->button_url }}" class="btn donate">{{ $banner->button_text }}</a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="slide active" style="background-image:url('{{ asset('assests/images/slide1.jpg') }}');">
                <div class="content">
                    <h1>Empowering Lives,<br>Building a Better Future</h1>
                    <hr>
                    <p>Together we can make a difference.</p>
                    <div class="hero-btns">
                        <a href="{{ route('donate') }}" class="btn donate">Donate Now</a>
                        <a href="#about" class="btn learn">Learn More</a>
                    </div>
                </div>
            </div>
        @endforelse

    </div>
</section>

<div class="social-bar">
    <a href="https://youtube.com/@suvabanifoundation?si=vvx08zGmsC5jKG9l" target="_blank" class="icon youtube">
        <i class="fab fa-youtube"></i>
    </a>
    <a href="https://www.facebook.com/SUVABANIFOUNDATION" target="_blank" class="icon facebook">
        <i class="fab fa-facebook-f"></i>
    </a>
    <a href="https://www.instagram.com/suvabanifoundation_?igsh=dW05dzc5NDFiczJo" target="_blank" class="icon instagram">
        <i class="fab fa-instagram"></i>
    </a>
</div>

@if($featuredCampaigns->isNotEmpty())
    @include('frontend.partials.campaign-cards')
@endif

<!-- ABOUT -->
<section class="about container my-5" id="about">
    <h2>About Our Trust</h2>
    <p>Dedicated to helping those in need and bringing positive change to society.</p>

    <div class="row mt-4 g-4">

        <div class="col-lg-4 col-md-6 col-12">
            <div class="card h-100 text-center shadow-sm">
                <i class="fas fa-hands-helping fa-3x mb-3" style="color: #003f88;"></i>
                <h3>Our Mission</h3>
                <p>Helping the needy and empowering communities.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12">
            <div class="card h-100 text-center shadow-sm">
                <i class="fas fa-eye fa-3x mb-3" style="color: #003f88;"></i>
                <h3>Our Vision</h3>
                <p>Creating a sustainable and better tomorrow.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12">
            <div class="card h-100 text-center shadow-sm">
                <i class="fas fa-users fa-3x mb-3" style="color: #003f88;"></i>
                <h3>Get Involved</h3>
                <p>Become a volunteer and make an impact.</p>
            </div>
        </div>

    </div>
</section>

<!-- NOTICES SECTION -->
<section class="notices container-fluid px-3 px-md-5 my-5" style="max-width: 1400px;" id='notices'>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0" style="color: #003f88;"><i class="fas fa-bullhorn me-2" style="color: #003f88;"></i>Official Notices & Announcements</h2>
    </div>

    @if(!isset($notices) || $notices->isEmpty())
        <div class="alert alert-info text-center shadow-sm">No official notices available at the moment.</div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0" style="background:#fff;">
                <thead style="background:#003f88; color:#fff;">
                    <tr>
                        <th style="width: 70px;" class="text-center">Sl. No.</th>
                        <th style="width: 25%;">Notice Title</th>
                        <th style="width: 45%;">Description</th>
                        <th style="width: 120px;">Date</th>
                        <th class="text-end" style="width: 170px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notices as $notice)
                        <tr>
                            <td class="text-center fw-bold" style="color:#003f88;">{{ $loop->iteration }}</td>
                            <td class="fw-semibold" style="color: #111;">{{ $notice->title }}</td>
                            <td class="text-dark" style="line-height: 1.5; font-size: 14.5px;">{{ $notice->description ?: '-' }}</td>
                            <td style="white-space: nowrap; color: #555;">{{ $notice->created_at ? $notice->created_at->format('d M Y') : '-' }}</td>
                            <td class="text-end" style="white-space: nowrap;">
                                @if($notice->file_path)
                                    <a href="{{ route('notices.view', $notice->id) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1" title="View PDF">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('notices.download', $notice->id) }}" class="btn btn-sm btn-primary" title="Download PDF">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                @else
                                    <span class="badge bg-secondary font-weight-normal" style="font-weight: 500;">Notice Text Only</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>

<section class="home-video py-5 bg-light">
    <h2>{{ $video->title ?? 'Our Work in Action' }}</h2>

    <div class="container">
        <div class="video-wrapper ratio ratio-16x9 shadow rounded overflow-hidden">
            <iframe 
                src="{{ isset($video) && $video->youtube_url ? youtubeEmbedUrl($video->youtube_url) : youtubeEmbedUrl('https://youtu.be/D7Y-nJ8uiEA?si=0l81Uhlg6OqNGi1s') }}" 
                allowfullscreen>
            </iframe>
        </div>
    </div>
</section>


<!-- FOCUS AREAS -->
<section class="focus container my-5">
    <h2>Our Key Focus Areas</h2>

    <div class="row mt-4 g-4 text-center">

        <div class="col-lg-3 col-md-6 col-12">
            <div class="box shadow-sm rounded overflow-hidden" style="cursor:pointer;" onclick="window.location.href='{{ route('gallery') }}#child-welfare'">
                <img src="{{ asset('assests/images/focus/child.jpg') }}" alt="Child" class="img-fluid w-100" style="height: 220px; object-fit: cover;">
                <button class="img-btn green w-100 p-2 border-0 text-white" style="background:#0d6efd; pointer-events:none;">Child Welfare</button>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
            <div class="box shadow-sm rounded overflow-hidden" style="cursor:pointer;" onclick="window.location.href='{{ route('gallery') }}#women-empowerment'">
                <img src="{{ asset('assests/images/focus/woman.jpg') }}" alt="Woman" class="img-fluid w-100" style="height: 220px; object-fit: cover;">
                <button class="img-btn blue w-100 p-2 border-0 text-white" style="background:#003f88; pointer-events:none;">Women Empowerment</button>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
            <div class="box shadow-sm rounded overflow-hidden" style="cursor:pointer;" onclick="window.location.href='{{ route('gallery') }}#healthcare-support'">
                <img src="{{ asset('assests/images/focus/health.jpg') }}" alt="Health" class="img-fluid w-100" style="height: 220px; object-fit: cover;">
                <button class="img-btn teal w-100 p-2 border-0 text-white" style="background:#1a73e8; pointer-events:none;">Healthcare Support</button>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
            <div class="box shadow-sm rounded overflow-hidden" style="cursor:pointer;" onclick="window.location.href='{{ route('gallery') }}#education-for-all'">
                <img src="{{ asset('assests/images/focus/education.jpg') }}" alt="Education" class="img-fluid w-100" style="height: 220px; object-fit: cover;">
                <button class="img-btn navy w-100 p-2 border-0 text-white" style="background:#dc3545; pointer-events:none;">Education for All</button>
            </div>
        </div>

    </div>
</section>


<!-- PROJECTS -->
<section class="projects container my-5" id="projects">
    <h2>Recent Projects</h2>

    <div class="row mt-4 g-4 text-center">
        @forelse($recentProjects as $project)
            <div class="col-lg-4 col-md-6 col-12">
                <a href="{{ route('gallery') }}#{{ \Illuminate\Support\Str::slug($project->category) }}"
                   class="box shadow-sm rounded overflow-hidden d-block text-decoration-none"
                   aria-label="View {{ $project->category }} gallery">
                    <img src="{{ asset('storage/'.$project->image_path) }}"
                         alt="{{ $project->title }}"
                         class="img-fluid w-100"
                         style="height: 220px; object-fit: cover;">
                    <span class="img-btn blue w-100 p-2 border-0 text-white d-block"
                          style="background:#003f88;">{{ $project->title }}</span>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted mb-0">No recent projects are currently available.</p>
            </div>
        @endforelse
    </div>

    <div class="projects-btn-wrap mt-4 text-center">
        <a href="{{ route('gallery') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">View All Projects →</a>
    </div>
</section>

{{-- <!-- FEATURED CAMPAIGNS -->
@if($featuredCampaigns->isNotEmpty())
@push('styles')
<style>
    .campaigns-home { padding: 1.5rem 0 2.25rem; }
    .campaigns-home-header { margin-bottom: 1.25rem; }
    .campaigns-home-card {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 18px rgba(0, 0, 0, .12);
        background: #fff;
    }
    .campaigns-home-media { height: 215px; background: #eaf2fb; position: relative; }
    .campaigns-home-media img { width: 100%; height: 215px; object-fit: cover; }
    .campaigns-home-badge {
        position: absolute;
        z-index: 2;
        top: 0;
        right: 0;
        padding: .55rem .8rem;
        border-radius: 0 0 0 16px;
        background: #f74355;
        color: #fff;
        font-size: .75rem;
        font-weight: 700;
    }
    .campaigns-home-card .carousel-control-prev,
    .campaigns-home-card .carousel-control-next { width: 12%; }
    .campaigns-home-card .carousel-indicators { margin-bottom: .5rem; }
    .campaigns-home-card .card-body { padding: 1.1rem 1.15rem 1rem; }
    .campaigns-home-card h3 { color: #202020 !important; line-height: 1.3; }
    .campaigns-home-progress { height: 9px; background: #eee; }
    .campaigns-home-progress .progress-bar { background: #f74355; }
    .campaigns-home-metrics { border-bottom: 1px solid #ddd; }
    .campaigns-home-metric { border-right: 1px solid #ddd; }
    .campaigns-home-metric:last-child { border-right: 0; }
    .campaigns-home-metric-icon {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #ffe8eb;
        color: #f74355;
    }
    .campaigns-home-social {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 10px;
        color: #202020;
        text-decoration: none;
        font-weight: 700;
    }
    .campaigns-home-donate {
        background: #f74355;
        border-color: #f74355;
        border-radius: 10px;
        box-shadow: 0 4px 0 #111;
        font-weight: 700;
    }
</style>
@endpush
<section class="campaigns-home container">
    <div class="campaigns-home-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Support a Cause</h2>
            <p class="mb-0 text-muted">Help make a meaningful difference today.</p>
        </div>
        <a href="{{ route('campaigns.index') }}" class="btn btn-outline-primary rounded-pill">View all</a>
    </div>
    <div class="row g-4">
        @foreach($featuredCampaigns as $campaign)
            @php($raised = $campaign->totalDonations())
            @php($progress = $campaign->progressPercentage())
            <div class="col-md-6 col-lg-4">
                @php($campaignImageCount = $campaign->media->count() + ($campaign->cover_media_path ? 1 : 0))
                <article class="card h-100 campaigns-home-card">
                    @if($campaignImageCount > 0)
                        <div id="campaignCarousel{{ $campaign->id }}" class="carousel slide campaigns-home-media" data-bs-ride="carousel">
                            <span class="campaigns-home-badge">Tax Benefit</span>
                            @if($campaignImageCount > 1)
                                <div class="carousel-indicators">
                                    @if($campaign->cover_media_path)
                                        <button type="button" data-bs-target="#campaignCarousel{{ $campaign->id }}"
                                                data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                                    @endif
                                    @foreach($campaign->media as $media)
                                        <button type="button" data-bs-target="#campaignCarousel{{ $campaign->id }}"
                                                data-bs-slide-to="{{ $loop->index + ($campaign->cover_media_path ? 1 : 0) }}"
                                                class="{{ !$campaign->cover_media_path && $loop->first ? 'active' : '' }}"
                                                aria-label="Slide {{ $loop->iteration + ($campaign->cover_media_path ? 1 : 0) }}"></button>
                                    @endforeach
                                </div>
                            @endif
                            <div class="carousel-inner">
                                @if($campaign->cover_media_path)
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/'.$campaign->cover_media_path) }}" alt="{{ $campaign->title }}">
                                    </div>
                                @endif
                                @foreach($campaign->media as $media)
                                    <div class="carousel-item {{ !$campaign->cover_media_path && $loop->first ? 'active' : '' }}">
                                        <img src="{{ asset('storage/'.$media->file_path) }}" alt="{{ $media->caption ?: $campaign->title }}">
                                    </div>
                                @endforeach
                            </div>
                            @if($campaignImageCount > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#campaignCarousel{{ $campaign->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#campaignCarousel{{ $campaign->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span><span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 mb-2">{{ Str::limit($campaign->title, 72) }}</h3>
                        @if($campaign->short_description)
                            <p class="text-muted small mb-3">{{ Str::limit($campaign->short_description, 110) }}</p>
                        @endif
                        <div class="progress campaigns-home-progress mb-2" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width:{{ $progress }}%"></div>
                        </div>
                        <div class="row g-0 campaigns-home-metrics py-3 mb-3">
                            <div class="col-4 campaigns-home-metric">
                                <div class="campaigns-home-metric-icon"><i class="fas fa-bullseye"></i></div>
                                <small class="d-block text-muted mt-1">Goal</small>
                                <strong class="small">₹{{ number_format($campaign->goal_amount / 100, 0) }}</strong>
                            </div>
                            <div class="col-4 campaigns-home-metric ps-2">
                                <div class="campaigns-home-metric-icon"><i class="fas fa-rupee-sign"></i></div>
                                <small class="d-block text-muted mt-1">Raised</small>
                                <strong class="small">₹{{ number_format($raised / 100, 0) }}</strong>
                            </div>
                            <div class="col-4 campaigns-home-metric ps-2">
                                <div class="campaigns-home-metric-icon"><i class="fas fa-users"></i></div>
                                <small class="d-block text-muted mt-1">Donors</small>
                                <strong class="small">{{ $campaign->donorCount() }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-2 mt-auto">
                            <div class="d-flex gap-2">
                                <a href="#" class="campaigns-home-social" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="campaigns-home-social" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="campaigns-home-social" aria-label="Share on X">X</a>
                            </div>
                            <a href="{{ route('donate', ['campaign' => $campaign->slug]) }}" class="btn btn-danger campaigns-home-donate px-3 py-2">Donate Now</a>
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
</section>
@endif --}}

<!-- GALLERY -->
<section class="home-gallery bg-white py-5">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 text-center text-md-start">
            <div>
                <h2>Gallery</h2>
                <p>Photos and videos from our recent work.</p>
            </div>
            <a href="{{ route('gallery') }}" class="btn btn-outline-primary rounded-pill mt-3 mt-md-0 px-4 fw-semibold">View Gallery →</a>
        </div>

        @if($homeGallery->isEmpty())
            <p>No gallery items found.</p>
        @else
            <div class="row g-4">
                @foreach($homeGallery as $item)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="home-gallery-card border rounded shadow-sm overflow-hidden h-100 d-flex flex-column" style="background: #f5f9ff;">
                            <div class="home-gallery-media d-flex align-items-center justify-content-center" style="height: 220px; background: #0f172a; overflow: hidden;">
                                @if($item->type === 'image' && $item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" 
                                         alt="{{ $item->title }}" 
                                         class="w-100 h-100" 
                                         style="object-fit: contain; cursor: pointer; transition: transform 0.2s ease;" 
                                         title="Click to view full size"
                                         onmouseover="this.style.transform='scale(1.03)'"
                                         onmouseout="this.style.transform='scale(1)'"
                                         onclick="openGalleryLightbox('{{ asset('storage/'.$item->image) }}', '{{ addslashes($item->title) }}')">
                                @elseif($item->type === 'youtube' && $item->video_url)
                                    <div class="ratio ratio-16x9 w-100 h-100">
                                        <iframe src="{{ youtubeEmbedUrl($item->video_url) }}" allowfullscreen></iframe>
                                    </div>
                                @endif
                            </div>

                            <div class="home-gallery-info p-3 mt-auto">
                                <strong class="d-block">{{ $item->title }}</strong>
                                <span class="d-block mt-1" style="color: #24527f; font-size: 14px;">{{ $item->category }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- LIGHTBOX OVERLAY MODAL -->
<div id="homeGalleryLightbox" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.92); z-index:99999; align-items:center; justify-content:center; flex-direction:column; padding:20px; box-sizing:border-box;" onclick="closeGalleryLightbox(event)">
    <button style="position:absolute; top:20px; right:25px; color:#fff; font-size:32px; font-weight:bold; cursor:pointer; background:rgba(255,255,255,0.2); border:none; width:45px; height:45px; border-radius:50%; display:flex; align-items:center; justify-content:center; line-height:1;" onclick="closeGalleryLightbox(event)" title="Close">&times;</button>
    <img id="homeLightboxImg" style="max-width:90vw; max-height:82vh; object-fit:contain; border-radius:8px; box-shadow:0 10px 30px rgba(0,0,0,0.8);" src="" alt="">
    <div id="homeLightboxTitle" style="color:#fff; margin-top:15px; font-size:18px; font-weight:500; text-align:center;"></div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assests/js/script.js') }}"></script>
<script>
function openGalleryLightbox(src, title) {
    const modal = document.getElementById('homeGalleryLightbox');
    const img = document.getElementById('homeLightboxImg');
    const titleEl = document.getElementById('homeLightboxTitle');
    
    img.src = src;
    img.alt = title || '';
    titleEl.textContent = title || '';
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeGalleryLightbox(e) {
    const modal = document.getElementById('homeGalleryLightbox');
    if (e.target.id === 'homeGalleryLightbox' || e.target.tagName === 'BUTTON' || e.target.parentElement?.tagName === 'BUTTON') {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('homeGalleryLightbox');
        if (modal && modal.style.display === 'flex') {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
});
</script>
@endpush
