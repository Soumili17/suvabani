<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>

body {
    margin: 0;
    padding: 0;
    font-family: DejaVu Sans, sans-serif;
}

.card {
    position: relative;
    width: 520px;
    height: 320px;
}

.background {
    position: absolute;
    top: 0;
    left: 0;
    width: 520px;
    height: 320px;
}

.photo {
    position: absolute;
    top: 70px;
    left: 40px;
    width: 120px;
    height: 120px;
    border-radius: 60px;
    overflow: hidden;
}

.photo img {
    width: 100%;
    height: 100%;
}

.name {
    position: absolute;
    top: 200px;
    left: 40px;
    font-size: 18px;
    font-weight: bold;
    color: #0d6efd;
}

.details {
    position: absolute;
    top: 80px;
    left: 200px;
    font-size: 12px;
}

.logo {
    position: absolute;
    top: 40px;
    right: 40px;
    width: 80px;
}

</style>
</head>
<body>

<div class="card">

    <!-- Background -->
    <img class="background" src="{{ public_path('assets/idcard-bg.png') }}">

    <!-- Photo -->
    @if($member->photo)
        <div class="photo">
            <img src="{{ storage_path('app/public/'.$member->photo) }}">
        </div>
    @endif

    <!-- Logo -->
    <img class="logo" src="{{ public_path('assets/image/fromlogo.png') }}">

    <!-- Name -->
    <div class="name">
        {{ $member->fullname }}
    </div>

    <!-- Details -->
    <div class="details">
        <div>Email: {{ $member->email }}</div>
        <div>Phone: {{ $member->phone }}</div>
        <div>Gender: {{ $member->gender }}</div>
        <div>Membership: {{ $member->membership }}</div>
        <div>Date: {{ $member->declaration_date }}</div>
    </div>

</div>

</body>
</html>