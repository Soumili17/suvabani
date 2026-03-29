<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Get in Touch | SUVABANI FOUNDATION</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', sans-serif; } body { background: linear-gradient(135deg, #eef3ff, #d6e4ff); color: #003f88; line-height:1.6; } /* HEADER */ header { display:flex; justify-content:space-between; align-items:center; padding:15px 50px; background:#003f88; color:white; } header img { height:60px;margin-top:17px; } .header-buttons a { text-decoration:none; margin-left:15px; padding:8px 18px; border-radius:5px; font-weight:bold; transition:0.3s; } .home { background:white; color:#003f88; } .home:hover { background:#0d6efd; color:white; } .join { background:#dc3545; color:white; } .join:hover { background:#b02a37; } /* TITLE */ .page-title { text-align:center; margin:40px 0; font-size:34px; font-weight:600; color:#003f88; } /* CONTAINER */ .container { display:flex; flex-wrap:wrap; gap:30px; max-width:1100px; margin:0 auto 60px auto; padding:0 20px; } /* LEFT FORM */ .left, .right { flex:1; min-width:320px; background:white; padding:35px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.08); } .left h2 { margin-bottom:25px; color:#003f88; } label { display:block; margin-top:18px; font-weight:600; } input, textarea { width:100%; padding:12px; margin-top:6px; border:1px solid #ccc; border-radius:6px; outline:none; transition:0.3s; } input:focus, textarea:focus { border-color:#0d6efd; box-shadow:0 0 6px rgba(13,110,253,0.2); } textarea { resize:vertical; min-height:130px; } button { background:#0d6efd; color:white; border:none; padding:12px 28px; border-radius:6px; cursor:pointer; font-size:16px; margin-top:25px; transition:0.3s; } button:hover { background:#003f88; } /* RIGHT INFO */ .right h3 { margin-bottom:20px; color:#003f88; } .right p { margin-bottom:12px; } .icon { margin-right:8px; color:#0d6efd; } /* SUCCESS MESSAGE */ .success { background:#fde2e4; color:#842029; padding:10px; margin-bottom:20px; border-radius:5px; } /* RESPONSIVE */ @media(max-width:768px){ header { flex-direction:column; text-align:center; } .header-buttons { margin-top:10px; } .container { flex-direction:column; } }
</style>
</head>
<body>

<header>
<img src="{{ asset('assests/images/formlogo.png') }}">

    <div class="header-buttons">
        <a href="{{ url('/') }}" class="home">Home</a>
        <a href="{{ url('/join') }}" class="join">Join Us</a>
    </div>
</header>

<div class="page-title">Get in Touch</div>

<div class="container">

    <!-- LEFT -->
    <div class="left">
        <h2>Send Us a Message</h2>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf

            <label>Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Message</label>
            <textarea name="message" required></textarea>

            <button type="submit">
                <i class="fas fa-paper-plane"></i> Send Message
            </button>
        </form>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <h3>Contact Information</h3>

        <p><strong>Address:</strong><br>
            Rania Pravat Pally,<br>
            P.O. Boral, P.S. Narendrapur,<br>
            Kolkata – 700 154
        </p>

        <p><i class="fas fa-phone icon"></i> <strong>Phone:</strong> 7059590022</p>

        <p><i class="fas fa-envelope icon"></i> <strong>Email:</strong>
            <a href="mailto:suvabanifoundation@gmail.com">
                suvabanifoundation@gmail.com
            </a>
        </p>
    </div>

</div>
@if(session('success'))
<script>
    alert("{{ session('success') }}");
    window.location.href = "{{ route('home') }}";
</script>
@endif
</body>
</html>
