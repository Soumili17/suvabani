<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>

body{
margin:0;
font-family:Arial, Helvetica, sans-serif;
}

.card{

width:520px;
height:320px;

border:2px solid #008080;
border-radius:10px;

position:relative;
overflow:hidden;

}

/* HEADER */

.header{

background:#008080;
color:white;

padding:10px;

text-align:center;

}

.header img{
height:40px;
position:absolute;
left:10px;
top:5px;
}

.header h3{
margin:0;
font-size:18px;
}

/* BODY */

.body{
padding:10px;
display:flex;
}

/* PHOTO */

.photo{

width:120px;
text-align:center;

}

.photo img{
width:100px;
height:120px;
object-fit:cover;

border:2px solid #ccc;
}

/* DETAILS */

.details{
flex:1;
padding-left:10px;
font-size:14px;
}

.details p{
margin:5px 0;
}

/* FOOTER */

.footer{

position:absolute;
bottom:0;

width:100%;

background:#f5f5f5;
padding:8px;

display:flex;
justify-content:space-between;
align-items:center;

}

/* SIGNATURE */

.signature img{
height:40px;
}

.sign-label{
font-size:10px;
text-align:center;
}

/* MEMBER ID */

.member-id{
font-weight:bold;
color:#008080;
font-size:16px;
}

</style>

</head>

<body>

<div class="card">

<!-- HEADER -->
<div class="header">
<a href="/"><img src="{{ asset('assests/images/formlogo.png') }}"></a>


<h3>SUVABANI FOUNDATION</h3>

</div>


<!-- BODY -->
<div class="body">

<div class="photo">

<img src="{{ storage_path('app/public/'.$member->photo) }}">

</div>


<div class="details">

<p class="member-id">
ID: {{ $member->membership_id }}
</p>

<p>
<strong>Name:</strong>
{{ $member->fullname }}
</p>

<p>
<strong>Phone:</strong>
{{ $member->phone }}
</p>

<p>
<strong>Member Type:</strong>
{{ $member->membertype }}
</p>

<p>
<strong>Joined:</strong>
{{ date('d-m-Y',strtotime($member->created_at)) }}
</p>

</div>

</div>


<!-- FOOTER -->

<div class="footer">

<div class="signature">

<img src="{{ public_path('assests/images/sign.png') }}}">

<div class="sign-label">
Chairman Signature
</div>

</div>

<div>

Valid Member

</div>

</div>


</div>

</body>
</html>