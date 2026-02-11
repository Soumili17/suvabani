@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- HERO SLIDER -->
<section class="slider">
    <div class="slides">
        @foreach($heroBanners as $banner)
        <div class="slide {{ $loop->first ? 'active' : '' }}" style="background-image:url('{{ asset('storage/'.$banner->image_path) }}');">
            <div class="content text-center text-white">
                <h1>{{ $banner->title }}</h1>
                <hr style="border-color: #ffc107; width: 50px;">
                <p>{{ $banner->subtitle }}</p>
                @if($banner->button_text)
                <a href="{{ $banner->button_url }}" class="btn btn-warning mt-3">{{ $banner->button_text }}</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- ABOUT -->
<section class="about py-5 text-center bg-light">
  <h2>About SUVABANI FOUNDATION</h2>
  <p class="lead">Dedicated to helping those in need and bringing positive change to society.</p>

  <div class="row mt-4 justify-content-center">
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm p-3 h-100">
        <i class="fas fa-hands-helping fa-2x text-success mb-2"></i>
        <h5>Our Mission</h5>
        <p>Helping the needy</p>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm p-3 h-100">
        <i class="fas fa-eye fa-2x text-primary mb-2"></i>
        <h5>Our Vision</h5>
        <p>Creating a better tomorrow</p>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm p-3 h-100">
        <i class="fas fa-users fa-2x text-warning mb-2"></i>
        <h5>Get Involved</h5>
        <p>Become a volunteer</p>
      </div>
    </div>
  </div>
</section>

<!-- FOCUS AREAS -->
<section class="focus py-5">
  <div class="container">
    <h2 class="text-center mb-4">Our Key Focus Areas</h2>
    <div class="row g-3">
      <div class="col-md-3">
        <div class="focus-card text-center p-3 shadow-sm">
          <i class="fas fa-child fa-2x text-success mb-2"></i>
          <h5>Child Welfare</h5>
        </div>
      </div>
      <div class="col-md-3">
        <div class="focus-card text-center p-3 shadow-sm">
          <i class="fas fa-female fa-2x text-primary mb-2"></i>
          <h5>Women Empowerment</h5>
        </div>
      </div>
      <div class="col-md-3">
        <div class="focus-card text-center p-3 shadow-sm">
          <i class="fas fa-hospital fa-2x text-warning mb-2"></i>
          <h5>Healthcare Support</h5>
        </div>
      </div>
      <div class="col-md-3">
        <div class="focus-card text-center p-3 shadow-sm">
          <i class="fas fa-book fa-2x text-danger mb-2"></i>
          <h5>Education for All</h5>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- RECENT PROJECTS -->
<section class="projects py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">Recent Works</h2>
    <div class="row g-3">
        @foreach($recentProjects as $project)
        <div class="col-md-3">
            <div class="project-card shadow-sm">
                <img src="{{ asset('storage/'.$project->image_path) }}" class="img-fluid rounded" alt="{{ $project->title }}">
                <div class="project-info mt-2 text-center">
                    <h6>{{ $project->title }}</h6>
                    <a href="{{ $project->url ?? '#' }}" class="btn btn-success btn-sm mt-1">View More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ url('/projects') }}" class="btn btn-outline-success">View All Projects</a>
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
/* Hero Slider */
.slider {
    position: relative;
    height: 450px;
    overflow: hidden;
}
.slide {
    position: absolute;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    display: none;
}
.slide.active { display: block; }
.slide .content { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }

/* Focus Cards */
.focus-card { border-radius: 8px; background-color: #fff; transition: transform 0.3s; }
.focus-card:hover { transform: translateY(-5px); }

/* Project Cards */
.project-card { border-radius: 8px; background-color: #fff; padding: 5px; transition: transform 0.3s; }
.project-card:hover { transform: translateY(-5px); }
</style>
@endpush

@push('scripts')
<script>
// Simple slider script
let slides = document.querySelectorAll('.slide');
let index = 0;
if(slides.length > 0){
    slides[index].classList.add('active');
    setInterval(() => {
        slides[index].classList.remove('active');
        index = (index+1) % slides.length;
        slides[index].classList.add('active');
    }, 5000);
}
</script>
@endpush
