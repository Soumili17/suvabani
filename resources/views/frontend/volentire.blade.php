@extends('frontend.layouts.app')

@section('title', 'Volunteer Page')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center mb-5">
        <div class="col-md-6 text-center">
            <input type="text" id="search" placeholder="Search by name..." 
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
                        @if($v->id_card)
                            <img src="{{ asset('storage/'.$v->id_card) }}" 
                                 class="card-img-top" style="height:200px;object-fit:cover;">
                        @else
                            <img src="{{ asset('assests/images/default-user.png') }}" 
                                 class="card-img-top" style="height:200px;object-fit:cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">{{ $v->name }}</h5>
                            <p class="card-text mb-1 text-muted">{{ $v->email }}</p>
                            <p class="card-text text-muted">{{ $v->phone }}</p>
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
        if(name.includes(input)){
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    });
}
</script>
@endpush