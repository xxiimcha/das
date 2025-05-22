<!DOCTYPE html>
<html>
<head>
    <title>Account Credentials</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>

    <p>Your account has been created with the following details:</p>

    <p>
        <strong>Email:</strong> {{ $user->email }}<br>
        <strong>Temporary Password:</strong> {{ $plaintextPassword }}
    </p>

    <p>Please log in and change your password as soon as possible.</p>

    <p>Thank you,<br>
    Dormitory Accreditation System</p>
</body>
</html>
