<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | SUVABANI FOUNDATION</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f0f8f8; display:flex; justify-content:center; align-items:center; height:100vh; }

        .login-container {
            background: #fff; 
            padding: 40px 30px; 
            border-radius: 12px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 400px; 
            text-align:center;
        }

        .login-container h2 {
            color: #008080; 
            margin-bottom: 20px;
        }

        .login-container form {
            display:flex; flex-direction:column;
        }

        input[type="email"], input[type="password"] {
            padding: 12px 15px; 
            margin: 10px 0; 
            border:1px solid #ccc; 
            border-radius:6px; 
            outline:none; 
            transition:0.3s;
        }

        input:focus { border-color:#008080; box-shadow:0 0 5px rgba(0,128,128,0.3); }

        button {
            background: #008080; 
            color:#fff; 
            border:none; 
            padding:12px; 
            border-radius:6px; 
            cursor:pointer; 
            margin-top:15px; 
            font-size:16px;
            transition:0.3s;
        }

        button:hover { background:#006666; }

        .error-message {
            color:red; 
            font-size:14px; 
            margin-top:5px;
        }

        .remember {
            display:flex; 
            align-items:center; 
            justify-content:flex-start; 
            font-size:14px; 
            margin:10px 0;
        }

        a.forgot { font-size:14px; color:#008080; text-decoration:none; margin-left:auto; }
        a.forgot:hover { text-decoration:underline; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror

        <input type="password" name="password" placeholder="Password" required>
        @error('password')
            <div class="error-message">{{ $message }}</div>
        @enderror

        <div class="remember">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember" style="margin-left:5px;">Remember Me</label>
            <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>
        </div>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
