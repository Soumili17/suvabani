<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Volunteer Page</title>
<link rel="stylesheet" href="{{ asset('assests/css/style.css') }}">
</head>
<body>

<header class="navbar">
  <a href="/"><img src="{{ asset('assests/images/formlogo.png') }}" height="90px" width="80px"></a>
    
    <div class="logo">SUVABANI FOUNDATION</div>

    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="#about">About</a>
        <a href="{{ route('contact') }}">Contact</a>
        <a href="/volunteers">Volunteer</a>
        <a href="#gallery">Gallery</a>

        <a href="{{ route('donate') }}" class="btn donate">Donate</a>
        <a href="{{ route('join') }}" class="btn join">Join Us</a>
    </nav>
</header>

<!-- SEARCH -->
<section>
  <input type="text" id="search" placeholder="Search by name..." 
         class="btn" style="width:300px;" onkeyup="searchVolunteer()">
</section>

<!-- VOLUNTEER LIST -->
<section>
  <h2>Our Volunteers</h2>

  @if($volunteers->isEmpty())
    <p>No volunteers found.</p>
  @else

  <div class="grid" id="volunteerContainer">

    @foreach($volunteers as $v)
      <div class="card volunteer-card">

        @if($v->id_card)
          <img src="{{ asset('storage/'.$v->id_card) }}" 
               style="width:100%;height:200px;object-fit:cover;">
        @else
          <img src="{{ asset('assests/images/default-user.png') }}" 
               style="width:100%;height:200px;object-fit:cover;">
        @endif

        <h3>{{ $v->name }}</h3>
        <p>{{ $v->email }}</p>
        <p>{{ $v->phone }}</p>

      </div>
    @endforeach

  </div>

  @endif
</section>

<div class="footer">
  <div class="footer-bottom">© 2026 NGO</div>
</div>

<script>
function searchVolunteer(){
  const input = document.getElementById('search').value.toLowerCase();
  const cards = document.querySelectorAll('.volunteer-card');

  cards.forEach(card => {
    const name = card.querySelector('h3').innerText.toLowerCase();

    if(name.includes(input)){
      card.style.display = "";
    } else {
      card.style.display = "none";
    }
  });
}
</script>

</body>
</html>