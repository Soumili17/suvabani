@extends('frontend.layouts.app')

@section('title', 'Gallery')

@push('styles')
<style>
.gallery-section{ margin-top:50px; }
.gallery-section h2{ margin-bottom:15px; border-left:5px solid #0d6efd; padding-left:10px; }
.gallery-card{ background:white; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.1); transition:0.3s; position:relative; height: 100%; display: flex; flex-direction: column; }
.gallery-card:hover{ transform:translateY(-5px); }
.media-box{ width:100%; height:200px; position:relative; overflow:hidden; background: #f0f0f0; }
.media-box img, .media-box iframe{ width:100%; height:100%; object-fit:cover; border:0; }
.play-icon{ position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:40px; color:white; background:rgba(0,0,0,0.5); padding:10px 15px; border-radius:50%; pointer-events:none; }
.gallery-title{ padding:15px; text-align:center; font-weight:bold; margin-top: auto; }
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
                      <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="img-fluid">
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

@endsection