@extends('frontend.layouts.app')

@section('title', 'Gallery')

@push('styles')
<style>
.gallery-section{ margin-top:50px; }
.gallery-section h2{ margin-bottom:15px; border-left:5px solid #0d6efd; padding-left:10px; }
.gallery-card{ background:white; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.1); transition:0.3s; position:relative; height: 100%; display: flex; flex-direction: column; }
.gallery-card:hover{ transform:translateY(-5px); }
.media-box{ width:100%; height:220px; position:relative; overflow:hidden; background: #0f172a; display:flex; align-items:center; justify-content:center; }
.media-box img{ width:100%; height:100%; object-fit:contain; border:0; cursor:pointer; transition: transform 0.2s ease; }
.media-box img:hover{ transform: scale(1.03); }
.media-box iframe{ width:100%; height:100%; object-fit:cover; border:0; }
.play-icon{ position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:40px; color:white; background:rgba(0,0,0,0.5); padding:10px 15px; border-radius:50%; pointer-events:none; }
.gallery-title{ padding:15px; text-align:center; font-weight:bold; margin-top: auto; }

/* LIGHTBOX MODAL */
.gallery-lightbox-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.92);
    z-index: 99999;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 20px;
    box-sizing: border-box;
}
.gallery-lightbox-modal.active {
    display: flex;
}
.gallery-lightbox-content {
    max-width: 90vw;
    max-height: 82vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.8);
    animation: zoomIn 0.25s ease-out;
}
.gallery-lightbox-title {
    color: #ffffff;
    margin-top: 15px;
    font-size: 18px;
    font-weight: 500;
    text-align: center;
}
.gallery-lightbox-close {
    position: absolute;
    top: 20px;
    right: 25px;
    color: #ffffff;
    font-size: 32px;
    font-weight: bold;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
    transition: background 0.2s, transform 0.2s;
}
.gallery-lightbox-close:hover {
    background: rgba(255, 255, 255, 0.4);
    transform: scale(1.1);
}
@keyframes zoomIn {
    from { transform: scale(0.85); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
</style>
@endpush

@section('content')

<div class="container my-5">
  <h1 class="mb-4 text-center fw-bold" style="color: #003f88;">Our Gallery</h1>

  @if($grouped->isEmpty())
    <p class="text-center text-muted">No gallery items found.</p>
  @else

    @foreach($grouped as $category => $items)

      <div class="gallery-section" id="{{ \Illuminate\Support\Str::slug($category) }}">
        <h2 class="fs-4 text-primary">{{ $category }}</h2>

        <div class="row g-4 mt-2">

          @foreach($items as $item)

            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
              <div class="gallery-card">
                <div class="media-box">
                  {{-- IMAGE --}}
                  @if($item->type === 'image')
                      <img src="{{ asset('storage/'.$item->image) }}" 
                           alt="{{ $item->title }}" 
                           class="img-fluid"
                           title="Click to view full size"
                           onclick="openGalleryLightbox('{{ asset('storage/'.$item->image) }}', '{{ addslashes($item->title) }}')">
                  @endif

                  {{-- YOUTUBE VIDEO --}}
                  @if($item->type === 'youtube' && $item->video_url)
                      <iframe src="{{ youtubeEmbedUrl($item->video_url) }}" allowfullscreen></iframe>
                      <div class="play-icon">▶</div>
                  @endif
                </div>
                <div class="gallery-title">
                  {{ $item->title }}
                </div>
              </div>
            </div>

          @endforeach

        </div>
      </div>

    @endforeach

  @endif
</div>

<!-- LIGHTBOX OVERLAY MODAL -->
<div id="galleryLightbox" class="gallery-lightbox-modal" onclick="closeGalleryLightbox(event)">
    <button class="gallery-lightbox-close" onclick="closeGalleryLightbox(event)" title="Close">&times;</button>
    <img id="lightboxImg" class="gallery-lightbox-content" src="" alt="">
    <div id="lightboxTitle" class="gallery-lightbox-title"></div>
</div>

<script>
function openGalleryLightbox(src, title) {
    const modal = document.getElementById('galleryLightbox');
    const img = document.getElementById('lightboxImg');
    const titleEl = document.getElementById('lightboxTitle');
    
    img.src = src;
    img.alt = title || '';
    titleEl.textContent = title || '';
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeGalleryLightbox(e) {
    if (e.target.id === 'galleryLightbox' || e.target.classList.contains('gallery-lightbox-close')) {
        const modal = document.getElementById('galleryLightbox');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('galleryLightbox');
        if (modal && modal.classList.contains('active')) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
});
</script>

@endsection