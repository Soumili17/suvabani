@extends('frontend.layouts.app')

@section('title', 'Volunteer Page')

@section('content')

<div class="container my-5">
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
@endpush