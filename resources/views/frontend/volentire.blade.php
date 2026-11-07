@extends('frontend.layouts.app')

@section('title', 'Volunteer Page')

@push('styles')
<style>
    .volunteer-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .volunteer-inquiry-panel[hidden] {
        display: none !important;
    }

    .volunteer-glow {
        animation: volunteer-button-glow 1.8s ease-in-out infinite;
        box-shadow: 0 0 0 rgba(0, 63, 136, 0.55);
    }

    @keyframes volunteer-button-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(0, 63, 136, 0.55); }
        50% { box-shadow: 0 0 0 8px rgba(0, 63, 136, 0); }
    }
</style>
@endpush

@section('content')

<div class="container my-5">
    <div class="volunteer-page-header">
        <h1 class="h2 mb-0" style="color:#003f88;">Volunteer with us</h1>
        <button type="button" class="btn btn-primary volunteer-glow" id="toggleVolunteerInquiry"
                aria-controls="volunteerInquiryPanel" aria-expanded="false">
            Interested in volunteering
        </button>
    </div>

    @if(session('inquiry_success'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('inquiry_success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-5 volunteer-inquiry-panel" id="volunteerInquiryPanel"
         @if(!$errors->any() && !session('inquiry_success')) hidden @endif>
        <div class="card-body p-4">
            <h2 class="fw-bold text-primary">Volunteer inquiry</h2>
            <p class="text-muted">Share your details and our team will get back to you.</p>

            <form method="POST" action="{{ route('volunteer_inquiries.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile no</label>
                        <input type="text" name="mobile_no" value="{{ old('mobile_no') }}" class="form-control" required>
                        @error('mobile_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alt mobile no</label>
                        <input type="text" name="alt_mobile_no" value="{{ old('alt_mobile_no') }}" class="form-control">
                        @error('alt_mobile_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gmail</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-9">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pin code</label>
                        <input type="text" name="pin_code" value="{{ old('pin_code') }}" class="form-control" required>
                        @error('pin_code') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Aadhar card</label>
                        <input type="file" name="aadhar_card" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        @error('aadhar_card') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pan card</label>
                        <input type="file" name="pan_card" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        @error('pan_card') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 volunteer-glow">Submit Inquiry</button>
            </form>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-6 text-center">
            <input type="text" id="search" placeholder="Search by name or designation..." 
                   class="form-control form-control-lg shadow-sm w-100" onkeyup="searchVolunteer()">
        </div>
    </div>

    <!-- VOLUNTEER LIST -->
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #003f88;">Our Volunteers</h2>
    </div>

    @if($volunteers->isEmpty())
        <p class="text-center text-muted">No volunteers found.</p>
    @else
        <div class="row g-4" id="volunteerContainer">
            @foreach($volunteers as $v)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 volunteer-card">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        @if($v->profile_pic)
                            <img src="{{ asset('storage/'.$v->profile_pic) }}" 
                                 class="card-img-top" style="height:200px;object-fit:cover;"
                                 alt="{{ $v->name }}">
                        @else
                            <img src="{{ asset('assests/images/default-user.png') }}" 
                                 class="card-img-top" style="height:200px;object-fit:cover;"
                                 alt="{{ $v->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">{{ $v->name }}</h5>
                            <p class="card-text mb-1 text-muted fst-italic">{{ $v->designation ?? '' }}</p>

                            @if($v->profile_pic)
                                <a href="{{ asset('storage/'.$v->profile_pic) }}"
                                   download="{{ Str::slug($v->name) }}-id-card"
                                   class="btn btn-sm btn-outline-primary mt-2"
                                   style="border-radius:20px; font-size:13px;">
                                    ⬇ Download ID Card
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function searchVolunteer(){
    const input = document.getElementById('search').value.toLowerCase();
    const cards = document.querySelectorAll('.volunteer-card');

    cards.forEach(card => {
        const name = card.querySelector('h5').innerText.toLowerCase();
        const designation = card.querySelector('p') ? card.querySelector('p').innerText.toLowerCase() : '';
        if(name.includes(input) || designation.includes(input)){
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    });
}
</script>
<script>
const volunteerInquiryToggle = document.getElementById('toggleVolunteerInquiry');
const volunteerInquiryPanel = document.getElementById('volunteerInquiryPanel');

volunteerInquiryToggle?.addEventListener('click', function () {
    const isHidden = volunteerInquiryPanel.hasAttribute('hidden');
    volunteerInquiryPanel.toggleAttribute('hidden', !isHidden);
    this.setAttribute('aria-expanded', String(isHidden));

    if (isHidden) {
        volunteerInquiryPanel.querySelector('input, textarea')?.focus();
    }
});
</script>
@endpush