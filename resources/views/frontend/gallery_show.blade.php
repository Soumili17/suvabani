<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gallery</title>
<link rel="stylesheet" href="{{ asset('assests/css/style.css') }}">

<style>
.gallery-section{
  margin-top:50px;
}

.gallery-section h2{
  text-align:left;
  margin-bottom:15px;
  border-left:5px solid #0d6efd;
  padding-left:10px;
}

.gallery-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:20px;
}

.gallery-card{
  background:white;
  border-radius:10px;
  overflow:hidden;
  box-shadow:0 5px 15px rgba(0,0,0,0.1);
  transition:0.3s;
}

.gallery-card:hover{
  transform:translateY(-5px);
}

.gallery-card img{
  width:100%;
  height:200px;
  object-fit:cover;
}

.gallery-title{
  padding:8px;
  text-align:center;
  font-weight:bold;
}
</style>

</head>
<body>

<header class="navbar">
    <img src="{{ asset('assests/images/formlogo.png') }}" height="90px" width="80px">
    <div class="logo">SUVABANI FOUNDATION</div>

    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="#about">About</a>
        <a href="{{ route('contact') }}">Contact</a>
        <a href="/volunteers">Volunteer</a>
        <a href="{{ route('gallery') }}">Gallery</a>

        <a href="{{ route('donate') }}" class="btn donate">Donate</a>
        <a href="{{ route('join') }}" class="btn join">Join Us</a>
    </nav>
</header>

<section>
  <h1>Our Gallery</h1>

  @if($grouped->isEmpty())
    <p>No gallery images found.</p>
  @else

  @foreach($grouped as $category => $items)

    <div class="gallery-section">
      <h2>{{ $category }}</h2>

      <div class="gallery-grid">

        @foreach($items as $item)
          <div class="gallery-card">

            <img src="{{ asset('storage/'.$item->image) }}" 
                 style="width:100%;height:200px;object-fit:cover;">

            <div class="gallery-title">
              {{ $item->title }}
            </div>

          </div>
        @endforeach

      </div>
    </div>

  @endforeach

  @endif

</section>
<div class="footer">
  <div class="footer-bottom">© 2026 NGO</div>
</div>

<script>
function searchGallery(){
  let input = document.getElementById('search').value.toLowerCase();
  let cards = document.querySelectorAll('.gallery-card');

  cards.forEach(card => {
    let text = card.innerText.toLowerCase();

    card.style.display = text.includes(input) ? "" : "none";
  });
}
</script>

</body>
</html>