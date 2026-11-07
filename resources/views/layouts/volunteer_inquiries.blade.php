@extends('layouts.dashboard')

@section('content')
<style>
    .inquiry-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .inquiry-table th, .inquiry-table td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: top; }
    .inquiry-table th { background: #0f9d94; color: white; }
    .inquiry-table a { color: #006f68; }
    .inquiry-photo { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; }
    .btn-danger { background: #dc3545; color: white; border: 0; padding: 6px 10px; border-radius: 6px; cursor: pointer; }
</style>

<h2>Volunteer Inquiries</h2>

<form method="GET" action="{{ route('dashboard.volunteer_inquiries') }}" style="margin:15px 0;">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search name, mobile or email" style="padding:8px;width:280px;">
    <button type="submit" class="btn-action">Search</button>
    <a href="{{ route('dashboard.volunteer_inquiries') }}" class="btn-action">Reset</a>
</form>

@if($inquiries->isEmpty())
    <p>No volunteer inquiries found.</p>
@else
    <div style="overflow-x:auto;">
        <table class="inquiry-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Applicant</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Documents</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $inquiry)
                    <tr>
                        <td><img class="inquiry-photo" src="{{ asset('storage/'.$inquiry->image_path) }}" alt="{{ $inquiry->name }}"></td>
                        <td>{{ $inquiry->name }}</td>
                        <td>
                            {{ $inquiry->mobile_no }}<br>
                            {{ $inquiry->alt_mobile_no ?: 'No alternate number' }}<br>
                            {{ $inquiry->email }}
                        </td>
                        <td>{{ $inquiry->address }}<br>{{ $inquiry->pin_code }}</td>
                        <td>
                            <a href="{{ route('dashboard.volunteer_inquiries.document', [$inquiry->id, 'aadhar']) }}">Aadhar</a><br>
                            <a href="{{ route('dashboard.volunteer_inquiries.document', [$inquiry->id, 'pan']) }}">PAN</a>
                        </td>
                        <td>{{ $inquiry->created_at->format('d-m-Y') }}</td>
                        <td>
                            <form action="{{ route('dashboard.volunteer_inquiries.delete', $inquiry->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" onclick="return confirm('Delete this inquiry?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px;">{{ $inquiries->links() }}</div>
@endif
@endsection
