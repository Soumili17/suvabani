<!DOCTYPE html>
<html>
<head>

<title>Download Membership Card</title>

<style>

body{
font-family:Arial;
background:#f4f7f7;
padding:40px;
}

.container{
max-width:500px;
margin:auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

h2{
text-align:center;
color:#008080;
}

input{
width:100%;
padding:12px;
margin-top:10px;
border:1px solid #ccc;
border-radius:6px;
}

button{
width:100%;
padding:12px;
margin-top:15px;
background:#008080;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
font-size:16px;
}

button:hover{
background:#006666;
}

.error{
color:red;
margin-top:10px;
}

.success{
color:green;
margin-top:10px;
}

</style>

</head>

<body>

<div class="container">

<h2>Download Membership Card</h2>

<form method="POST" action="{{ url('/membership/search') }}">
@csrf

<label>Enter Registered Mobile Number</label>

<input type="text" name="mobile" placeholder="Enter mobile number">

<button type="submit">Search Member</button>

</form>

@if ($errors->any())
<div class="error">
{{ $errors->first() }}
</div>
@endif

</div>

</body>
</html>