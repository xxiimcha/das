<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #eaeaea;
        }
        .email-header {
            background-color: #dc3545;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 1.4rem;
            font-weight: bold;
        }
        .email-body {
            padding: 25px;
            color: #333333;
            line-height: 1.6;
            text-align: center;
        }
        .email-body h1 {
            font-size: 1.6rem;
            color: #dc3545;
            margin-bottom: 15px;
        }
        .email-body p {
            margin: 10px 0;
            font-size: 1rem;
            color: #555555;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #dc3545;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #b71c1c;
        }
        .email-footer {
            background-color: #f4f4f4;
            color: #888888;
            text-align: center;
            padding: 15px;
            font-size: 0.85rem;
            border-top: 1px solid #eaeaea;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            Welcome to UNC DAS!
        </div>
        <div class="email-body">
            <h1>Hi, {{ $name }}!</h1>
            <p>We are thrilled to have you join our platform. Explore all the features and let us know if there’s anything we can assist you with.</p>
            <p>Click the button below to get started:</p>
            <a href="{{ url('/login') }}" class="btn">Log in to Your Account</a>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} UNC DAS. All rights reserved.
        </div>
    </div>
</body>
</html>
