@extends('layouts.dashboard')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="color:#0f9d94; margin:0;">Notices</h2>
    <a href="{{ route('dashboard.notices.create') }}" class="btn-action" style="padding:10px 20px; font-size:15px;">
        + Upload New Notice
    </a>
</div>

@if($notices->isEmpty())
    <p style="color:#555; text-align:center; padding:30px 0;">No notices found. Upload your first notice above.</p>
@else
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Uploaded On</th>
            <th style="text-align:center;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notices as $index => $notice)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $notice->title }}</td>
            <td>{{ $notice->created_at->format('d M Y') }}</td>
            <td style="text-align:center; white-space:nowrap;">
                {{-- View PDF --}}
                <a href="{{ route('notices.view', $notice->id) }}" target="_blank" class="btn-action"
                   style="background:#1a73e8; margin-right:5px;">View PDF</a>

                {{-- Edit --}}
                <a href="{{ route('dashboard.notices.edit', $notice->id) }}" class="btn-action"
                   style="background:#f5a623; margin-right:5px;">Edit</a>

                {{-- Delete --}}
                <form action="{{ route('dashboard.notices.delete', $notice->id) }}" method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Are you sure you want to delete this notice?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="padding:5px 12px; background:#dc3545; color:white; border:none;
                                   border-radius:6px; cursor:pointer; font-size:14px;">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
