<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SUVABANI FOUNDATION</title>

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assests/css/style.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

<!-- NAVBAR -->

<header class="navbar">

    <div class="logo-box">
        <a href="{{ route('home') }}" style="style:none;">
            <img src="{{ asset('assests/images/formlogo.png') }}" alt="logo">
        </a>
        <div class="logo">SUVABANI FOUNDATION</div>
        
    </div>

    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="#about">About</a>
        <a href="{{ route('contact') }}">Contact</a>
        <a href="/volunteers">Volunteer</a>
        <a href="{{ route('gallery') }}">Gallery</a>

        <a href="{{ route('donate') }}" class="btn donate">Donate</a>
        <a href="{{ route('join') }}" class="btn join">Join Us</a>
    </nav>

</header>




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
<section class="about" id="about">
    <h2>About Our Trust</h2>
    <p>Dedicated to helping those in need and bringing positive change to society.</p>

    <div class="about-cards">

        <div class="card">
            <i class="fas fa-hands-helping"></i>
            <h3>Our Mission</h3>
            <p>Helping the needy and empowering communities.</p>
        </div>

        <div class="card">
            <i class="fas fa-eye"></i>
            <h3>Our Vision</h3>
            <p>Creating a sustainable and better tomorrow.</p>
        </div>

        <div class="card">
            <i class="fas fa-users"></i>
            <h3>Get Involved</h3>
            <p>Become a volunteer and make an impact.</p>
        </div>

    </div>
</section>

<section class="home-video">
    <h2>{{ $video->title ?? 'Our Work in Action' }}</h2>

    <div class="video-wrapper">
        <iframe 
            src="{{ youtubeEmbedUrl('https://youtu.be/D7Y-nJ8uiEA?si=0l81Uhlg6OqNGi1s') }}" 
            allowfullscreen>
        </iframe>
    </div>
</section>


<!-- FOCUS AREAS -->
<section class="focus">
    <h2>Our Key Focus Areas</h2>

    <div class="grid">

        <div class="box">
        <img src="{{ asset('assests/images/focus/child.jpg') }}" alt="Child">
            <button class="img-btn green">Child Welfare</button>
        </div>

        <div class="box">
        <img src="{{ asset('assests/images/focus/woman.jpg') }}" alt="Woman">
            <button class="img-btn blue">Women Empowerment</button>
        </div>

        <div class="box">
        <img src="{{ asset('assests/images/focus/health.jpg') }}" alt="Health">
            <button class="img-btn teal">Healthcare Support</button>
        </div>

        <div class="box">
        <img src="{{ asset('assests/images/focus/education.jpg') }}" alt="Education">
            <button class="img-btn navy">Education for All</button>
        </div>

    </div>
</section>


<!-- PROJECTS -->
<section class="projects">
    <h2>Recent Projects</h2>

    <div class="grid">

    <div class="box">
    <img src="{{ asset('assests/images/project/food.jpg') }}" alt="Food Project">
        <button class="img-btn blue">Food Distribution</button>
    </div>

    <div class="box">
    <img src="{{ asset('assests/images/project/medical.jpg') }}" alt="Medical Project">
        <button class="img-btn green">Free Medical Camp</button>
    </div>

    <div class="box">
    <img src="{{ asset('assests/images/project/skill.jpg') }}" alt="Skill Development">
        <button class="img-btn teal">Skill Development</button>
    </div>

</div>

    <div class="projects-btn-wrap">
        <a href="#" class="view-all-btn">View All Projects →</a>
    </div>
</section>

<!-- GALLERY -->
<section class="home-gallery">
    <div class="section-title-row">
        <div>
            <h2>Gallery</h2>
            <p>Photos and videos from our recent work.</p>
        </div>

        <a href="{{ route('gallery') }}" class="view-all-btn">View Gallery →</a>
    </div>

    @if($homeGallery->isEmpty())
        <p>No gallery items found.</p>
    @else
        <div class="home-gallery-grid">
            @foreach($homeGallery as $item)
                <div class="home-gallery-card">
                    <div class="home-gallery-media">
                        @if($item->type === 'image' && $item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}">
                        @elseif($item->type === 'youtube' && $item->video_url)
                            <iframe src="{{ youtubeEmbedUrl($item->video_url) }}" allowfullscreen></iframe>
                        @endif
                    </div>

                    <div class="home-gallery-info">
                        <strong>{{ $item->title }}</strong>
                        <span>{{ $item->category }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>


<!-- FOOTER -->
<footer class="footer">
    <div class="footer-container">

        <div class="footer-box">
            <h2>SUVABANI FOUNDATION</h2>
            <p>Dedicated to social welfare and sustainable community development.</p>

            <div class="social-icons">
                <a href="https://www.facebook.com/SUVABANIFOUNDATION"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/suvabanifoundation_?igsh=dW05dzc5NDFiczJo"><i class="fab fa-instagram"></i></a>
                <a href="https://youtube.com/@suvabanifoundation?si=vvx08zGmsC5jKG9l"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-box">
            <h3>Contact Information</h3>
            <p>
                Rania Pravat Pally,<br>
                P.O. Boral, P.S. Narendrapur,<br>
                Kolkata – 700154
            </p>
        </div>

        <div class="footer-box">
            <h3>Reach Us</h3>
            <p>Phone: 7059590022</p>
            <p>Email:
                <a style="color:white;" href="mailto:suvabanifoundation@gmail.com">
                    suvabanifoundation@gmail.com
                </a>
            </p>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 SUVABANI FOUNDATION |
        <a href="{{ route('terms') }}">Terms & Conditions</a>
    </div>
</footer>


<!-- Back To Top -->
<button id="backTop">↑</button>

<!-- Main JS -->
<script src="{{ asset('assests/js/script.js') }}"></script>

</body>
</html>
