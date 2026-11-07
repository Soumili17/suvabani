@extends('layouts.dashboard')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:20px;">
    <h2 style="margin:0; color:#0f9d94;">Edit campaign</h2>
    <a href="{{ route('dashboard.campaigns.index') }}" class="btn-action" style="background:#555;">Back to campaigns</a>
</div>

@if ($errors->any())
    <div role="alert" style="margin-bottom:20px; padding:12px; color:#842029; background:#f8d7da; border-radius:8px;">
        <ul style="margin:0; padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('dashboard.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data" style="max-width:760px;">
    @csrf
    @method('PUT')
    @include('dashboard.campaigns.partials.form', ['campaign' => $campaign])
    <button type="submit" class="btn-action" style="border:0; cursor:pointer; padding:10px 18px;">Save changes</button>
</form>
@endsection
