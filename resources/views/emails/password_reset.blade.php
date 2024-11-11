<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h1>Password Reset Request</h1>
    <p>You requested a password reset. Click the link below to reset your password:</p>
    <a href="{{ url('password/reset/form?token=' . $token) }}">Reset Password</a>
</body>
</html>
