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

        @foreach($governingBodies as $member)
        <div class="col-lg-6 col-12">
            <div class="gov-card">
                @if($member->image)
                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}">
                @else
                    <div style="width:120px; height:120px; background:#eee; border-radius:10px; flex-shrink:0;"></div>
                @endif
                <div>
                    <h4>{{ $member->name }} – {{ $member->post }}</h4>
                    <p>{{ $member->description }}</p>
                </div>
            </div>
        </div>
        @endforeach

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