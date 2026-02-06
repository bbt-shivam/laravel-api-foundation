<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Changed</title>
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>
        This is a confirmation that your account password was
        successfully changed.
    </p>

    <p>
        If you did not perform this action, please contact our support
        team immediately.
    </p>

    <p>
        Thanks,<br>
        {{ config('app.name') }} Team
    </p>
</body>
</html>
