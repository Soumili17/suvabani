@extends('frontend.layouts.app')

@section('title', 'SUVABANI FOUNDATION - Home')

@section('content')

<!-- HERO SLIDER -->
<section class="slider">
    <div class="slides">

        <div class="slide active"
        style="background-image:url('{{ asset('assests/images/slide1.jpg') }}');">
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

        <div class="slide"
        style="background-image:url('{{ asset('assests/images/slide2.jpg') }}');">
            <div class="content">
                <h1>Support Education,<br>Support Future</h1>
                <hr>
                <p>Your small help can change a child’s life.</p>

                <div class="hero-btns">
                    <a href="{{ route('donate') }}" class="btn donate">Donate Now</a>
                    <a href="" class="btn learn">View Projects</a>
                </div>
            </div>
        </div>

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
<section class="projects container my-5">
    <h2>Recent Projects</h2>

    <div class="row mt-4 g-4 text-center">

        <div class="col-lg-4 col-md-6 col-12">
            <div class="box shadow-sm rounded overflow-hidden">
                <img src="{{ asset('assests/images/project/food.jpg') }}" alt="Food Project" class="img-fluid w-100" style="height: 220px; object-fit: cover;">
                <button class="img-btn blue w-100 p-2 border-0 text-white" style="background:#003f88;">Food Distribution</button>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12">
            <div class="box shadow-sm rounded overflow-hidden">
                <img src="{{ asset('assests/images/project/medical.jpg') }}" alt="Medical Project" class="img-fluid w-100" style="height: 220px; object-fit: cover;">
                <button class="img-btn green w-100 p-2 border-0 text-white" style="background:#0d6efd;">Free Medical Camp</button>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12">
            <div class="box shadow-sm rounded overflow-hidden">
                <img src="{{ asset('assests/images/project/skill.jpg') }}" alt="Skill Development" class="img-fluid w-100" style="height: 220px; object-fit: cover;">
                <button class="img-btn teal w-100 p-2 border-0 text-white" style="background:#1a73e8;">Skill Development</button>
            </div>
        </div>

    </div>

    <div class="projects-btn-wrap mt-4 text-center">
        <a href="#" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">View All Projects →</a>
    </div>
</section>

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
                            <div class="home-gallery-media" style="height: 190px; background: #e9f1fb;">
                                @if($item->type === 'image' && $item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="w-100 h-100" style="object-fit: cover;">
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

@endsection

@push('scripts')
<script src="{{ asset('assests/js/script.js') }}"></script>
@endpush
