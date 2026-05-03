@extends('frontend.layouts.app')

@section('title', 'Your 80G Donations | SUVABANI FOUNDATION')

@section('content')
<div class="container my-5 overflow-auto bg-white p-4 rounded shadow-sm">
    <h2 class="mb-4" style="color:#0f766e;">Your 80G Donations</h2>
    <table class="table table-bordered table-striped mt-3">
    <thead class="table-dark" style="background:#0f766e;">
    <tr>
    <th style="background:#0f766e; color:white;">Receipt</th>
    <th style="background:#0f766e; color:white;">Amount</th>
    <th style="background:#0f766e; color:white;">Date</th>
    <th style="background:#0f766e; color:white;">Download</th>
    </tr>
    </thead>
    <tbody>
    @foreach($donations as $donation)
    <tr>
    <td>{{ $donation->receipt_number }}</td>
    <td>₹{{ $donation->amount }}</td>
    <td>{{ \Carbon\Carbon::parse($donation->created_at)->format('d-m-Y') }}</td>
    <td><a class="btn btn-sm" style="background:#14b8a6; color:white;" href="{{ route('80g.download',$donation->id) }}">Download 80G</a></td>
    </tr>
    @endforeach
    </tbody>
    </table>
</div>
@endsection