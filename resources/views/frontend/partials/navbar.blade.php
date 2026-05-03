<style>
/* Scoped Navbar CSS to prevent breaking specific page styles while standardizing the navbar */
.main-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background: #003f88;
    flex-wrap: wrap;
    font-family: Segoe UI, sans-serif;
    margin: 0;
    width: 100%;
    box-sizing: border-box;
}
.main-navbar .logo-box {
    display: flex;
    align-items: center;
    gap: 10px;
}
.main-navbar .logo-box img {
    height: 45px;
    width: auto;
    border-radius: 5px;
    margin-top: 5px;
}
.main-navbar .logo {
    color: white;
    font-size: 20px;
    font-weight: bold;
}
.main-navbar nav {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.main-navbar nav a {
    color: white;
    margin: 0 10px;
    text-decoration: none;
    font-size: 15px;
}
.main-navbar nav a:hover {
    color: #ffccd2;
}
.main-navbar .btn-nav {
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
}
.main-navbar .donate-btn-nav {
    text-decoration: none;
    background-color: #dc3545;
    color: white !important;
}
.main-navbar .join-btn-nav {
    background: white;
    color: #003f88 !important;
    text-decoration: none;
}
@media (max-width: 768px) {
    .main-navbar {
        flex-direction: column;
        align-items: center;
        padding: 15px;
    }
    .main-navbar .logo-box {
        margin-bottom: 10px;
    }
    .main-navbar nav {
        justify-content: center;
        flex-wrap: wrap;
    }
    .main-navbar nav a {
        margin: 8px;
        font-size: 14px;
    }
    .main-navbar .btn-nav {
        display: inline-block;
        margin-top: 5px;
    }
}
</style>

<header class="main-navbar">
    <div class="logo-box">
        <a href="{{ route('home') }}" style="text-decoration:none;">
            <img src="{{ asset('assests/images/formlogo.png') }}" alt="logo">
        </a>
        <div class="logo">SUVABANI FOUNDATION</div>
    </div>

    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('home') }}#about">About</a>
        <a href="{{ route('contact') }}">Contact</a>
        <a href="/volunteers">Volunteer</a>
        <a href="{{ route('gallery') }}">Gallery</a>
        <a href="{{ route('donate') }}" class="btn-nav donate-btn-nav">Donate</a>
        <a href="{{ route('join') }}" class="btn-nav join-btn-nav">Join Us</a>
    </nav>
</header>
