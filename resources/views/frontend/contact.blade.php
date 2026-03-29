<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Get in Touch | SUVABANI FOUNDATION</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', sans-serif; }

body {
    background: linear-gradient(135deg, #f0f8f8, #d9f0f0);
    color: #033;
    line-height:1.6;
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

/* BUTTONS */
.header-buttons a {
    text-decoration:none;
    margin-left:15px;
    padding:8px 18px;
    border-radius:5px;
    font-weight:bold;
    transition:0.3s;
}
.home { background:white; color:#008080; }
.home:hover { background:#006666; color:white; }

.join { background:orangered; color:white; }
.join:hover { background:#cc3300; }

/* TITLE */
.page-title {
    text-align:center;
    margin:40px 0;
    font-size:34px;
    font-weight:600;
    color:#008080;
}

/* CONTAINER */
.container {
    display:flex;
    flex-wrap:wrap;
    gap:30px;
    max-width:1100px;
    margin:0 auto 60px auto;
    padding:0 20px;
}

/* BOXES */
.left, .right {
    flex:1;
    min-width:320px;
    background:white;
    padding:35px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

/* FORM */
label { display:block; margin-top:18px; font-weight:600; }

input, textarea {
    width:100%;
    padding:12px;
    margin-top:6px;
    border:1px solid #ccc;
    border-radius:6px;
}

textarea { min-height:130px; }

button {
    background:#008080;
    color:white;
    border:none;
    padding:12px 28px;
    border-radius:6px;
    margin-top:25px;
}

/* GOVERNING BODY */
.gov-section {
    max-width:1100px;
    margin:40px auto 60px;
    padding:0 20px;
}

.gov-title {
    text-align:center;
    font-size:30px;
    margin-bottom:30px;
    color:#008080;
}

.gov-card {
    display:flex;
    gap:20px;
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.gov-card img {
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:10px;
}

.gov-card h4 {
    color:#008080;
    margin-bottom:8px;
}

/* MOBILE */
@media(max-width:768px){
    .container { flex-direction:column; }
    .gov-card { flex-direction:column; text-align:center; }
}
</style>
</head>
<body>

<header>
    <img src="{{ asset('assests/images/formlogo.png') }}" alt="Logo">

    <div class="header-buttons">
        <a href="{{ url('/') }}" class="home">Home</a>
        <a href="{{ url('/join') }}" class="join">Join Us</a>
    </div>
</header>

<div class="page-title">Get in Touch</div>

<div class="container">

    <div class="left">
        <h2>Send Us a Message</h2>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
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

    <div class="right">
        <h3>Contact Information</h3>

        <p><strong>Address:</strong><br>
            Rania Pravat Pally,<br>
            P.O. Boral, P.S. Narendrapur,<br>
            Kolkata – 700 154
        </p>

        <p><i class="fas fa-phone"></i> 7059590022</p>
        <p><i class="fas fa-envelope"></i> contact@suvabanifoundation.com</p>
    </div>

</div>

<!-- GOVERNING BODY -->
<div class="gov-section">

    <div class="gov-title">Governing Body</div>

    <div class="gov-card">
        <img src="{{ asset('assests/images/officials/founder.webp') }}">
        <div>
            <h4>Suvo Debnath – Founder & President</h4>
            <p>SUVO DEBNATH is the Founder & President of the organization SUVABANI FOUNDATION, professionally working as a Businessman (Online Business) and holds a B.Com Degree in Accountancy from Calcutta University.
Driven by a strong sense of social responsibility, he plays a key role in advancing our mission of SUVABANI FOUNDATION. He believes in the power of community-driven change and works tirelessly to support and uplift underprivileged sections of society. Through his efforts, he aims to build a more inclusive and sustainable future.</p>
        </div>
    </div>
    <div class="gov-card">
        <img src="{{ asset('assests/images/officials/Secretary.png') }}">
        <div>
            <h4>Mihir Debnath – Secretary</h4>
            <p>MIHIR DEBNATH is the Secretary of the organization, responsible for administrative management, documentation, and communication. He ensures that the NGO operates efficiently and in compliance with all necessary guidelines.</p>
        </div>
    </div>
    <div class="gov-card">
        <img src="{{ asset('assests/images/officials/casher.jpeg') }}">
        <div>
            <h4>Suroj Halder – Cashier</h4>
            <p>SUROJ HALDER serves as the Cashier of the organization SUVABANI FOUNDATION  and is responsible for managing financial transactions, maintaining accounts, and ensuring proper utilization of funds. He works at a Finance Company and holds a B.Com Degree in Accountancy from Calcutta University.
With a strong understanding of financial management and accountability, Suroj Halder ensures transparency and accuracy in all financial matters of the organization.</p>
        </div>
    </div>

    <div class="gov-card">
        <img src="{{ asset('assests/images/officials/co1.jpeg') }}">
        <div>
            <h4>Smita Chakraborty – Communicating Officer</h4>
            <p>SMITA CHAKRABORTY is the Communicating Officer of SUVABANI FOUNDATION and by profession she works as a Customs Sircar Executive at a CHA company. She holds a Post Graduate degree from Rabindra Bharati University & studying Astgrology at IIA.
She manages communication strategies, media relations, and digital outreach. Her expertise helps the organization strengthen its public presence and effectively engage with the community.</p>
        </div>
    </div>

    <div class="gov-card">
        <img src="{{ asset('assests/images/officials/co2.jpeg') }}">
        <div>
            <h4>Pulak Bhunre – Communicating Officer</h4>
            <p>As the Communicating Officer, PULAK BHUNRE manages the organization’s communication strategy, including public relations, digital outreach, and stakeholder engagement. He works as a Businessman and has completed Graduation Degree.
He plays a vital role in ensuring clear messaging and strengthening the organization’s visibility and impact.</p>
        </div>
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