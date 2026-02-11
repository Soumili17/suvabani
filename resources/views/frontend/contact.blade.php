<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Get in Touch | SUVABANI FOUNDATION</title>
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', sans-serif; }

body {
    background: linear-gradient(135deg, #f0f8f8, #d9f0f0);
    color: #033;
    line-height:1.6;
    padding:0;
}

/* HEADER */
header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 50px;
    background:#008080;
    color:white;
}
header img { height:60px; }
.header-buttons a {
    text-decoration:none;
    margin-left:15px;
    padding:8px 18px;
    border-radius:5px;
    font-weight:bold;
    transition:0.3s;
}
.header-buttons a.home { background:white; color:#008080; }
.header-buttons a.home:hover { background:#006666; color:white; }
.header-buttons a.join { background:orangered; color:white; }
.header-buttons a.join:hover { background:#cc3300; color:white; }

/* PAGE TITLE */
.page-title {
    text-align:center;
    margin:30px 0;
    font-size:32px;
    color:#008080;
}

/* CONTAINER */
.container {
    display:flex;
    flex-wrap:wrap;
    gap:30px;
    max-width:1000px;
    margin:0 auto 50px auto;
}

/* LEFT FORM */
.left {
    flex:1;
    min-width:300px;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
.left h2 { margin-bottom:20px; }
.left form label { display:block; margin-top:15px; font-weight:600; }
.left form input, .left form textarea {
    width:100%;
    padding:10px 12px;
    margin-top:5px;
    border:1px solid #ccc;
    border-radius:6px;
    outline:none;
    transition:0.3s;
}
.left form input:focus, .left form textarea:focus { border-color:#008080; box-shadow:0 0 5px rgba(0,128,128,0.3); }
.left form textarea { resize:vertical; min-height:120px; }
.left form button {
    background:#008080;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:6px;
    cursor:pointer;
    font-size:16px;
    margin-top:20px;
    transition:0.3s;
}
.left form button:hover { background:#006666; }

/* RIGHT CONTACT INFO */
.right {
    flex:1;
    min-width:300px;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
.right h3 { margin-bottom:15px; }
.right p { margin-bottom:10px; line-height:1.5; }
.right a { color:#008080; text-decoration:none; }
.right a:hover { text-decoration:underline; }
.right .icon { margin-right:8px; color:#008080; }

/* RESPONSIVE */
@media(max-width:768px){
    header { flex-direction:column; text-align:center; }
    .header-buttons { margin-top:10px; }
    .container { flex-direction:column; }
}
</style>
</head>
<body>

<!-- HEADER -->
<header>
<img src="{{ asset('assets/images/formlogo.png') }}" alt="Logo">

    <div class="header-buttons">
    <a href="{{ url('/join') }}" class="btn join">Join Us</a>
    <a href="{{ url('/index') }}" class="btn home">Home</a>
    </div>
</header>

<!-- PAGE TITLE -->
<div class="page-title">Get in Touch</div>

<!-- MAIN CONTAINER -->
<div class="container">
    <!-- LEFT FORM -->
    <div class="left">
        <h2>Send Us a Message</h2>
        <form id="contactForm" action="submit_contact.php" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name">

            <label for="email">Email</label>
            <input type="email" id="email" name="email">

            <label for="message">Message</label>
            <textarea id="message" name="message"></textarea>

            <button type="submit"><i class="fas fa-paper-plane"></i> Send Message</button>
        </form>
    </div>

    <!-- RIGHT CONTACT INFO -->
    <div class="right">
        <h3>Contact Information</h3>
        <p><strong>Address:</strong><br>
            Rania Pravat Pally,<br>
            P.O. Boral, P.S. Narendrapur,<br>
            Kolkata – 700 154
        </p>
        <div class="footer-box">
            <h3>Reach Us</h3>
            <p><i class="fas fa-phone icon"></i> <strong>Phone:</strong> 7059590022</p>
            <p><i class="fas fa-envelope icon"></i> <strong>Email:</strong> 
                <a href="mailto:suvabanifoundation@gmail.com">suvabanifoundation@gmail.com</a>
            </p>
        </div>
    </div>
</div>

<script>
// JS VALIDATION
document.getElementById('contactForm').addEventListener('submit', function(e){
    e.preventDefault();
    const form = this;

    if(form.name.value.trim() === '') { alert('Please enter your name.'); return false; }
    if(form.email.value.trim() === '') { alert('Please enter your email.'); return false; }
    if(!/^\S+@\S+\.\S+$/.test(form.email.value)) { alert('Please enter a valid email address.'); return false; }
    if(form.message.value.trim() === '') { alert('Please enter your message.'); return false; }

    // If valid, submit
    form.submit();
});
</script>

</body>
</html>

        