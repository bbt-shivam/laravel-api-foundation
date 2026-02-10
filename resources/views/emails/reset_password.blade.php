<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>
        This is a confirmation that your account password was
        successfully changed.
    </p>

    <p>
        This is your Reset Password Link

        <a href="{{ $reset_password_url }}">Click Here.</a>
    </p>

    <p>
        Thanks,<br>
        {{ config('app.name') }} Team
    </p>
</body>
</html>
