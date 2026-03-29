<!DOCTYPE html>
<html>
<head>
<title>Your 80G Donations</title>

<style>

body{
font-family:Arial;
background:#f8fafc;
padding:50px;
}

table{
width:100%;
border-collapse:collapse;
background:white;
}

th,td{
padding:12px;
border:1px solid #ddd;
}

th{
background:#0f766e;
color:white;
}

a.download{
background:#14b8a6;
color:white;
padding:6px 12px;
border-radius:5px;
text-decoration:none;
}

</style>

</head>

<body>

<h2>Your 80G Donations</h2>

<table>

<tr>
<th>Receipt</th>
<th>Amount</th>
<th>Date</th>
<th>Download</th>
</tr>

@foreach($donations as $donation)

<tr>

<td>{{ $donation->receipt_number }}</td>

<td>₹{{ $donation->amount }}</td>

<td>{{ \Carbon\Carbon::parse($donation->created_at)->format('d-m-Y') }}</td>

<td>
<a class="download" href="{{ route('80g.download',$donation->id) }}">
Download 80G
</a>

</td>

</tr>

@endforeach

</table>

</body>
</html>