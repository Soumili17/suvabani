<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NGO Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root{
            --teal:#0f9d94;
        }

        *{
            box-sizing:border-box;
            font-family:Segoe UI, sans-serif;
        }

        body{
            margin:0;
            background:linear-gradient(135deg,var(--teal),#0a6f68);
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .card{
            background:white;
            padding:35px;
            border-radius:14px;
            width:400px;
            box-shadow:0 10px 25px rgba(0,0,0,.2);
        }

        h2{
            text-align:center;
            color:var(--teal);
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border-radius:8px;
            border:1px solid #ddd;
        }

        button{
            width:100%;
            padding:12px;
            border:none;
            border-radius:8px;
            background:var(--teal);
            color:white;
            font-size:16px;
            cursor:pointer;
        }

        button:hover{
            background:#0b8077;
        }

        .note{
            text-align:center;
            margin-top:12px;
            color:#777;
            font-size:13px;
        }

        .error{
            color:red;
            text-align:center;
            margin-bottom:10px;
            font-size:14px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Suvabani Admin Login</h2>

    {{-- Error Message --}}
    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Login Form --}}
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <div class="note">
        demo: admin / 1234
    </div>
</div>

</body>
</html>