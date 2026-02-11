@extends('layouts.app')

@section('content')
<h1>Donate to SUVABANI FOUNDATION</h1>

<form action="{{ route('donate.store') }}" method="POST">
    @csrf
    <label>Name:</label>
    <input type="text" name="name" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Phone:</label>
    <input type="text" name="phone"><br>

    <label>Address:</label>
    <textarea name="address"></textarea><br>

    <label>Amount (₹):</label>
    <input type="number" name="amount" min="1" required><br>

    <button type="submit">Donate & Get Form 80C</button>
</form>
@endsection
