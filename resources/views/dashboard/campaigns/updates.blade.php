@extends('layouts.dashboard')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
    <h2 style="margin:0;color:#0f9d94;">Updates: {{ $campaign->title }}</h2>
    <a href="{{ route('dashboard.campaigns.index') }}" class="btn-action">Back to campaigns</a>
</div>

<form action="{{ route('dashboard.campaigns.updates.store', $campaign) }}" method="POST" enctype="multipart/form-data"
      style="max-width:760px;margin-top:20px;display:grid;gap:12px;">
    @csrf
    <label>Title <input name="title" required maxlength="255" style="width:100%;padding:10px;"></label>
    <label>Description <textarea name="description" rows="5" required style="width:100%;padding:10px;"></textarea></label>
    <label>Image <input type="file" name="image" accept="image/jpeg,image/png,image/webp"></label>
    <button class="btn-action" type="submit" style="border:0;width:max-content;">Publish update</button>
</form>

@forelse($updates as $update)
    <article style="border-top:1px solid #ddd;margin-top:24px;padding-top:16px;">
        <h3>{{ $update->title }}</h3>
        <small>{{ $update->published_at?->format('d M Y') }}</small>
        <p style="white-space:pre-line;">{{ $update->description }}</p>
        @if($update->image_path)
            <img src="{{ asset('storage/'.$update->image_path) }}" alt="{{ $update->title }}" style="max-width:240px;border-radius:8px;">
        @endif
        <form action="{{ route('dashboard.campaigns.updates.delete', $update) }}" method="POST" style="margin-top:8px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action" style="background:#b42318;border:0;" onclick="return confirm('Delete this update?')">Delete</button>
        </form>
    </article>
@empty
    <p style="margin-top:24px;">No updates published yet.</p>
@endforelse
@endsection
