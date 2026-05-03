@extends('frontend.layouts.app')

@section('title', 'Get in Touch | SUVABANI FOUNDATION')

@push('styles')
<style>
.page-title { text-align:center; margin:40px 0; font-size:34px; font-weight:600; }
.left, .right { background:white; padding:35px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.08); }
.success { background:#fde2e4; color:#842029; padding:10px; margin-bottom:20px; border-radius:5px; }

.gov-title { text-align:center; font-size:32px; font-weight:600; margin-bottom:40px; }
.gov-card { display:flex; gap:20px; background:white; padding:20px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.08); align-items:flex-start; transition:0.3s; height: 100%; }
.gov-card:hover { transform:translateY(-3px); }
.gov-card img { width:120px; height:120px; object-fit:cover; border-radius:10px; flex-shrink: 0; }
.gov-card h4 { margin-bottom:10px; color:#003f88; }
.gov-card p { font-size:14px; color:#444; }

@media(max-width:576px){
    .gov-card { flex-direction:column; align-items:center; text-align:center; }
    .gov-card img { width:100px; height:100px; }
}
</style>
@endpush

@section('content')

<div class="page-title">Get in Touch</div>

<div class="container mb-5">
    <div class="row g-4">
        
        <div class="col-lg-6 col-12">
            <div class="left h-100">
                <h2 class="mb-4">Send Us a Message</h2>

                @if(session('success'))
                <div class="success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Message</label>
                    <textarea name="message" class="form-control" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3 px-4 py-2">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
                </form>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="right h-100">
                <h3 class="mb-4">Contact Information</h3>
                
                <p><strong>Address:</strong><br>
                Rania Pravat Pally,<br>
                P.O. Boral, P.S. Narendrapur,<br>
                Kolkata – 700 154
                </p>

                <p class="mt-3"><i class="fas fa-phone text-primary"></i> 7059590022</p>
                <p><i class="fas fa-envelope text-primary"></i> contact@suvabanifoundation.com</p>
            </div>
        </div>

    </div>
</div>

<!-- GOVERNING BODY -->
<div class="container mb-5">
    <div class="gov-title">Governing Body</div>

    <div class="row g-4 justify-content-center">

        <div class="col-lg-6 col-12">
            <div class="gov-card">
                <img src="{{ asset('assests/images/officials/founder.webp') }}">
                <div>
                    <h4>Suvo Debnath – Founder & President</h4>
                    <p>SUVO DEBNATH is the Founder & President of the organization SUVABANI FOUNDATION, professionally working as a Businessman (Online Business) and holds a B.Com Degree in Accountancy from Calcutta University.
                    Driven by a strong sense of social responsibility, he plays a key role in advancing our mission of SUVABANI FOUNDATION. He believes in the power of community-driven change and works tirelessly to support and uplift underprivileged sections of society. Through his efforts, he aims to build a more inclusive and sustainable future.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="gov-card">
                <img src="{{ asset('assests/images/officials/Secretary.png') }}">
                <div>
                    <h4>Mihir Debnath – Secretary</h4>
                    <p>MIHIR DEBNATH is the Secretary of the organization, responsible for administrative management, documentation, and communication. He ensures that the NGO operates efficiently and in compliance with all necessary guidelines.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="gov-card">
                <img src="{{ asset('assests/images/officials/casher.jpeg') }}">
                <div>
                    <h4>Suroj Halder – Cashier</h4>
                    <p>SUROJ HALDER serves as the Cashier of the organization SUVABANI FOUNDATION and is responsible for managing financial transactions, maintaining accounts, and ensuring proper utilization of funds. He works at a Finance Company and holds a B.Com Degree in Accountancy from Calcutta University. With a strong understanding of financial management and accountability, Suroj Halder ensures transparency and accuracy in all financial matters of the organization.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="gov-card">
                <img src="{{ asset('assests/images/officials/co1.jpeg') }}">
                <div>
                    <h4>Smita Chakraborty – Communicating Officer</h4>
                    <p>SMITA CHAKRABORTY is the Communicating Officer of SUVABANI FOUNDATION and by profession she works as a Customs Sircar Executive at a CHA company. She holds a Post Graduate degree from Rabindra Bharati University & studying Astgrology at IIA. She manages communication strategies, media relations, and digital outreach. Her expertise helps the organization strengthen its public presence and effectively engage with the community.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12 text-center mx-auto">
            <div class="gov-card">
                <img src="{{ asset('assests/images/officials/co2.jpeg') }}">
                <div>
                    <h4>Pulak Bhunre – Communicating Officer</h4>
                    <p>As the Communicating Officer, PULAK BHUNRE manages the organization’s communication strategy, including public relations, digital outreach, and stakeholder engagement. He works as a Businessman and has completed Graduation Degree. He plays a vital role in ensuring clear messaging and strengthening the organization’s visibility and impact.</p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
@if(session('success'))
<script>
    alert("{{ session('success') }}");
    window.location.href = "{{ route('home') }}";
</script>
@endif
@endpush