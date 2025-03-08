<!DOCTYPE html>
<html>
<head>
    <title>Dormitory Registration Successful</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            padding: 20px;
        }
        .header {
            text-align: center;
            background-color: #b71c1c;
            color: #ffffff;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            text-align: left;
        }
        .content h2 {
            color: #b71c1c;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .content p {
            margin: 10px 0;
            line-height: 1.6;
            font-size: 14px;
        }
        .content ul {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }
        .content ul li {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .content ul li strong {
            color: #b71c1c;
        }
        .content ul li span {
            background-color: #f5f5f5;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: monospace;
            display: inline-block;
            color: #333;
        }
        .content a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #b71c1c;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
        }
        .content a:hover {
            background-color: #a91313;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #757575;
            font-size: 12px;
        }
        .footer span {
            color: #b71c1c;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dormitory Management</h1>
        </div>
        <div class="content">
            <h2>Hello, {{ $details['name'] }}</h2>
            <p>Your dormitory registration has been successfully completed. Below are your login credentials:</p>
            <ul>
                <li><strong>Email:</strong> <span>{{ $details['email'] }}</span></li>
                <li><strong>Password:</strong> <span>{{ $details['password'] }}</span></li>
            </ul>
            <p>Your application is currently pending review. You will be notified of the next steps via email.</p>
            <p>You can log in to your account to manage your dormitory details:</p>
            <a href="{{ url('/login') }}">Log in to Your Account</a>
            <p>Thank you for registering with the Dormitory Management System!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} <span>Dormitory Management System</span>. All rights reserved.
        </div>
    </div>
</body>
</html>