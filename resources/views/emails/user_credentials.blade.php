<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f4f6f8;
            padding:20px;
        }
        .card {
            background:#fff;
            padding:25px;
            max-width:500px;
            margin:auto;
            border-radius:8px;
        }
        .btn {
            background:#4f46e5;
            color:#fff;
            padding:10px 16px;
            text-decoration:none;
            border-radius:5px;
            display:inline-block;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Welcome 👋</h2>

    <p>Your account has been created.</p>

    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>

    <p>Please change your password after login.</p>

    <a href="{{ url('/login') }}" class="btn">Login Now</a>
</div>

</body>
</html>
