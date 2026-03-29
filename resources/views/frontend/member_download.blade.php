<!DOCTYPE html>
<html>
<head>

<title>Membership Card</title>

<style>

body{
font-family:Arial;
background:#f4f7f7;
padding:40px;
}

.container{
max-width:600px;
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

.info{
margin-top:20px;
}

.info p{
margin:6px 0;
}

.download-btn{
display:block;
text-align:center;
margin-top:20px;
padding:12px;
background:#008080;
color:white;
text-decoration:none;
border-radius:6px;
}

.download-btn:hover{
background:#006666;
}

.photo{
text-align:center;
margin-top:15px;
}

.photo img{
width:120px;
border-radius:6px;
border:1px solid #ccc;
}

</style>

</head>

<body>

<div class="container">

<h2>Member Found</h2>

<div class="photo">

<img src="{{ asset('storage/'.$member->photo) }}">

</div>

<div class="info">

<p><strong>Name:</strong> {{ $member->fullname }}</p>

<p><strong>Membership ID:</strong> {{ $member->membership_id }}</p>

<p><strong>Phone:</strong> {{ $member->phone }}</p>

<p><strong>Member Type:</strong> {{ $member->membertype }}</p>

<p><strong>Status:</strong> {{ $member->approval_status }}</p>

</div>

<a href="{{ route('membership.download',$member->id) }}"
class="download-btn">
Download Membership Card
</a>

</div>

</body>
</html>