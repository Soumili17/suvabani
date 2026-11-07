<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NGO Dashboard</title>

<style>
:root{--blue:#003f88;--blue-dark:#002b5c;--light:#f5f9ff;--ink:#16324f}
*{box-sizing:border-box;font-family:Segoe UI,Arial,sans-serif}
body{margin:0;background:var(--light);display:flex;color:var(--ink)}
.sidebar{width:250px;background:linear-gradient(180deg,var(--blue),var(--blue-dark));color:#fff;height:100vh;padding:22px 10px;position:fixed;display:flex;flex-direction:column;overflow:hidden}
.logo{text-align:center;font-size:22px;font-weight:700;margin-bottom:22px}
.nav{overflow-y:auto;min-height:0;padding:2px 0 70px}
.nav a{display:flex;align-items:center;gap:12px;color:#fff;text-decoration:none;padding:12px 16px;margin:5px 4px;border-radius:10px}
.nav a:hover{background:rgba(255,255,255,.16)}
.main{margin-left:250px;padding:30px;width:calc(100% - 250px)}
.main>h1{color:var(--blue);font-size:30px;margin-top:0}
.card{background:#fff;padding:24px;border-radius:16px;box-shadow:0 8px 24px rgba(0,43,92,.09);margin-bottom:20px}
.overview-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
.overview-stat{padding:22px;border-radius:16px;color:#fff;min-height:135px;box-shadow:0 8px 18px rgba(0,43,92,.15)}
.overview-stat:nth-child(1){background:linear-gradient(135deg,#003f88,#1a73e8)}
.overview-stat:nth-child(2){background:linear-gradient(135deg,#0f766e,#14b8a6)}
.overview-stat:nth-child(3){background:linear-gradient(135deg,#7c3aed,#a855f7)}
.overview-stat:nth-child(4){background:linear-gradient(135deg,#c2410c,#f97316)}
.overview-stat i{font-size:24px;opacity:.85}.overview-stat strong{display:block;font-size:27px;margin-top:12px}.overview-stat span{font-size:13px;opacity:.9}
.page-heading{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap}.page-heading h2{color:var(--blue);margin:0}.page-heading p{margin:5px 0 0;color:#6b7b8d}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px}
table{width:100%;border-collapse:collapse;margin-top:20px}th,td{border:1px solid #e1e8f0;padding:10px;text-align:left}th{background:var(--blue);color:white}.table-wrap{overflow-x:auto}
.btn-action{padding:7px 12px;background:var(--blue);color:white;border-radius:7px;text-decoration:none;margin:3px;border:0;cursor:pointer;display:inline-block}.btn-action:hover{background:var(--blue-dark);color:#fff}.btn-action.danger{background:#b42318}
.success{background:#d4edda;color:#155724;padding:10px;margin-bottom:20px;border-radius:8px;text-align:center}.empty-state{padding:20px;background:#f5f9ff;border-radius:10px;margin-top:20px}.banner-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:18px;margin-top:22px}.banner-card{overflow:hidden;border:1px solid #e1e8f0;border-radius:14px;background:#fff}.banner-card>img{width:100%;height:160px;object-fit:cover}.banner-card-body{padding:14px}.banner-card-body small{display:block;color:#6b7b8d;margin:8px 0}.banner-actions{margin-top:12px}.status{padding:4px 8px;border-radius:999px;font-size:12px}.status-active{background:#dcfce7;color:#166534}.status-off{background:#e5e7eb;color:#475569}.pagination-wrap{margin-top:18px}
@media(max-width:900px){.overview-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:768px){body{flex-direction:column}.sidebar{width:100%;height:auto;max-height:270px;position:relative}.nav{display:flex;flex-wrap:wrap;justify-content:center}.nav a{padding:9px 12px;font-size:13px}.main{margin-left:0;width:100%;padding:15px}.overview-grid{grid-template-columns:1fr 1fr}.main>h1{font-size:24px}table{font-size:13px;white-space:nowrap}}
@media(max-width:480px){.overview-grid{grid-template-columns:1fr}}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div class="sidebar">
    <div class="logo">NGO Admin</div>
    <div class="nav">
        <a href="{{ route('dashboard') }}">Overview</a>
        <a href="{{ route('dashboard.members') }}">Members</a>
        <a href="{{ route('dashboard.messages') }}">Messages</a>
        <a href="{{ route('dashboard.donors') }}">Donors</a>
        <a href="{{ route('dashboard.volunteers') }}">Volunteers</a>
        <a href="{{ route('dashboard.volunteer_inquiries') }}">Volunteer Inquiries</a>
        <a href="{{ route('dashboard.gallery') }}">Gallery</a>
        <a href="{{ route('dashboard.home_video') }}">Home Video</a>
        <a href="{{ route('dashboard.hero_banners.index') }}">Landing Slider</a>
        <a href="{{ route('dashboard.governing_body.index') }}">Governing Body</a>
        <a href="{{ route('dashboard.notices') }}">Notices</a>
        <a href="{{ route('dashboard.campaigns.index') }}">Campaigns</a>
        <a href="{{ route('dashboard.projects.index') }}">Projects</a>
    </div>
</div>


<div class="main">
    <h1>Dashboard</h1>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="success" style="background:#f8d7da;color:#842029;">{{ session('error') }}</div>
    @endif

    @if(isset($stats))
        <div class="overview-grid">
            <div class="overview-stat"><i class="fas fa-bullhorn"></i><strong>{{ $stats['running_campaigns'] }}</strong><span>Running campaigns</span></div>
            <div class="overview-stat"><i class="fas fa-indian-rupee-sign"></i><strong>₹{{ number_format($stats['total_donations'], 0) }}</strong><span>Total successful donations</span></div>
            <div class="overview-stat"><i class="fas fa-users"></i><strong>{{ $stats['active_members'] }}</strong><span>Active members</span></div>
            <div class="overview-stat"><i class="fas fa-heart"></i><strong>{{ $stats['successful_donors'] }}</strong><span>Successful donors</span></div>
        </div>
    @endif

    <div class="card">
        @yield('content')
    </div>
</div>

@stack('styles')
@stack('scripts')
</body>
</html>