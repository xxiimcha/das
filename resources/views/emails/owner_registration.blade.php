<!DOCTYPE html>
<html>
<head>
    <title>Dormitory Registration Submitted</title>
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
            <h2>Hello, {{ $details['first_name'] }} {{ $details['last_name'] }}</h2>
            <p>Your dormitory registration has been successfully submitted.</p>
            <p>Your application is currently under review. You will receive an update via email once the evaluation process is completed.</p>
            <p>Thank you for registering with the Dormitory Management System!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} <span>Dormitory Management System</span>. All rights reserved.
        </div>
    </div>
</body>
</html>
