<!DOCTYPE html>
<html>
<head>
<title>Find 80G Certificate</title>

<style>

body{
font-family:Arial;
background:linear-gradient(135deg,#f8fafc,#e0f2f1);
}

.wrapper{
padding:100px 20px;
}

.card{
max-width:450px;
margin:auto;
background:white;
padding:40px;
border-radius:12px;
box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

input{
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-bottom:15px;
}

button{
width:100%;
padding:14px;
border:none;
border-radius:8px;
background:linear-gradient(135deg,#0f766e,#14b8a6);
color:white;
font-weight:bold;
cursor:pointer;
}

</style>

</head>

<body>

<div class="wrapper">

<div class="card">

<h2 style="text-align:center;color:#0f766e;">Find 80G Certificate</h2>

@if ($errors->any())
<div style="color:red;">
{{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('80g.search') }}">

@csrf

<input type="text" name="mobile" placeholder="Enter Mobile Number">

<button type="submit">Search Donations</button>

</form>

</div>

</div>

</body>
</html>