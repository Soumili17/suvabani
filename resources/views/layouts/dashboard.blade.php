<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NGO Dashboard</title>

<style>
:root{--teal:#0f9d94;--light:#f4fbfb}
*{box-sizing:border-box;font-family:Segoe UI}
body{margin:0;background:var(--light);display:flex}
.sidebar{width:230px;background:var(--teal);color:white;height:100vh;padding-top:20px;position:fixed}
.logo{text-align:center;font-size:22px;font-weight:bold;margin-bottom:25px}
.nav a{display:flex;align-items:center;gap:12px;color:white;text-decoration:none;padding:14px 25px;margin:6px 12px;border-radius:10px}
.nav a:hover{background:#0b8077}
.logout{position:absolute;bottom:20px;width:100%}
.main{margin-left:230px;padding:30px;width:100%}
.card{background:white;padding:20px;border-radius:14px;box-shadow:0 5px 15px rgba(0,0,0,.1);margin-bottom:20px}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px}
.stat{background:var(--teal);color:white;padding:28px;border-radius:14px;text-align:center;font-size:17px}
h1{color:var(--teal)}
table{width:100%;border-collapse:collapse;margin-top:20px}
th,td{border:1px solid #ddd;padding:10px;text-align:left}
th{background:#0f9d94;color:white}
a.btn-action{padding:5px 12px;background:#008080;color:white;border-radius:6px;text-decoration:none;margin-right:5px}
a.btn-action:hover{background:#0b8077}
.success{background:#d4edda;color:#155724;padding:10px;margin-bottom:20px;border-radius:5px;text-align:center;}
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
    </div>
</div>


<div class="main">
    <h1>Dashboard</h1>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="card">
        @yield('content')
    </div>
</div>

</body>
</html>