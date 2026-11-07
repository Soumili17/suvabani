@extends('layouts.dashboard')

@section('content')
<div class="page-heading">
    <div><h2>Landing page slider</h2><p>Manage the banners visitors see on the homepage.</p></div>
    <a href="{{ route('dashboard.hero_banners.create') }}" class="btn-action">Add banner</a>
</div>
@if($banners->isEmpty())
    <div class="empty-state">No banners added yet.</div>
@else
    <div class="banner-grid">
        @foreach($banners as $banner)
            <article class="banner-card">
                <img src="{{ asset('storage/'.$banner->image_path) }}" alt="{{ $banner->title }}">
                <div class="banner-card-body">
                    <div class="d-flex justify-content-between gap-2"><strong>{{ $banner->title ?: 'Untitled banner' }}</strong><span class="status {{ $banner->is_active ? 'status-active' : 'status-off' }}">{{ $banner->is_active ? 'Active' : 'Hidden' }}</span></div>
                    <small>{{ $banner->subtitle }}</small>
                    <div class="banner-actions">
                        <a href="{{ route('dashboard.hero_banners.edit', $banner) }}" class="btn-action">Edit</a>
                        <form method="POST" action="{{ route('dashboard.hero_banners.destroy', $banner) }}" onsubmit="return confirm('Delete this banner?')">@csrf @method('DELETE')<button class="btn-action danger">Delete</button></form>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
