<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>
        Registration successfull.
    </p>

    
    <p>
        Verify Your email here.
        
        <a href="{{ $verification_url }}">Click Here.</a>
    </p>

    <p>
        Thanks,<br>
        {{ config('app.name') }} Team
    </p>
</body>
</html>
