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

/* ---- Notices Dropdown ---- */
.notice-dropdown {
    position: relative;
    display: inline-block;
}
.notice-dropdown-toggle {
    color: white;
    text-decoration: none;
    font-size: 15px;
    margin: 0 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    background: none;
    border: none;
    padding: 0;
    font-family: inherit;
}
.notice-dropdown-toggle:hover {
    color: #ffccd2;
}
.notice-dropdown-toggle .caret {
    font-size: 10px;
    transition: transform 0.2s;
}
.notice-dropdown:hover .caret {
    transform: rotate(180deg);
}
.notice-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 10px);
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    min-width: 320px;
    z-index: 9999;
    overflow: hidden;
    animation: dropFadeIn 0.18s ease;
}
@keyframes dropFadeIn {
    from { opacity: 0; transform: translateX(-50%) translateY(-6px); }
    to   { opacity: 1; transform: translateX(-50%) translateY(0); }
}
.notice-dropdown:hover .notice-dropdown-menu {
    display: block;
}
.notice-dropdown-header {
    background: #003f88;
    color: white;
    padding: 12px 18px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 8px;
}
.notice-dropdown-empty {
    padding: 20px 18px;
    color: #888;
    font-size: 14px;
    text-align: center;
}
.notice-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 16px;
    border-bottom: 1px solid #f0f0f0;
    gap: 10px;
    transition: background 0.15s;
}
.notice-item:last-child {
    border-bottom: none;
}
.notice-item:hover {
    background: #f0f7ff;
}
.notice-item-title {
    font-size: 13.5px;
    color: #002b5c;
    font-weight: 500;
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: flex;
    align-items: center;
    gap: 8px;
}
.notice-item-title i {
    color: #dc3545;
    flex-shrink: 0;
}
.notice-item-actions {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
}
.notice-action-btn {
    padding: 4px 10px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.15s;
}
.notice-action-btn:hover {
    opacity: 0.85;
    text-decoration: none;
}
.notice-action-view {
    background: #1a73e8;
    color: white !important;
}
.notice-action-download {
    background: #0f9d94;
    color: white !important;
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
    .notice-dropdown-menu {
        left: 0;
        transform: translateX(0);
        min-width: 260px;
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

        {{-- Notices Dropdown --}}
        <div class="notice-dropdown">
            <button class="notice-dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell"></i>&nbsp;Notices
                <span class="caret">&#9660;</span>
            </button>

            <div class="notice-dropdown-menu" role="menu" aria-label="Notices">
                <div class="notice-dropdown-header">
                    <i class="fas fa-file-pdf"></i> Official Notices
                </div>

                @if(isset($navbarNotices) && $navbarNotices->isNotEmpty())
                    @foreach($navbarNotices as $notice)
                        <div class="notice-item">
                            <span class="notice-item-title" title="{{ $notice->title }}">
                                <i class="fas fa-file-pdf"></i>
                                {{ Str::limit($notice->title, 38) }}
                            </span>
                            <div class="notice-item-actions">
                                <a href="{{ route('notices.view', $notice->id) }}"
                                   target="_blank"
                                   class="notice-action-btn notice-action-view"
                                   title="View PDF in browser">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('notices.download', $notice->id) }}"
                                   class="notice-action-btn notice-action-download"
                                   title="Download PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="notice-dropdown-empty">
                        <i class="fas fa-inbox" style="font-size:22px; color:#ccc; display:block; margin-bottom:6px;"></i>
                        No notices available at the moment.
                    </div>
                @endif
            </div>
        </div>
        {{-- End Notices Dropdown --}}

        <a href="{{ route('donate') }}" class="btn-nav donate-btn-nav">Donate</a>
        <a href="{{ route('join') }}" class="btn-nav join-btn-nav">Join Us</a>
    </nav>
</header>
