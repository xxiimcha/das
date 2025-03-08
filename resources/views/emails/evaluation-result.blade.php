<!DOCTYPE html>
<html>
<head>
    <title>Dormitory Accreditation Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #b71c1c;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
        .status {
            font-weight: bold;
            color: {{ $schedule->status == 'passed' ? 'green' : 'red' }};
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Dormitory Accreditation Result
        </div>
        <div class="content">
            <p>Dear {{ $dormitory->owner->name ?? 'Dormitory Owner' }},</p>
            <p>Your dormitory <strong>{{ $dormitory->name }}</strong> has been reviewed.</p>
            <p><strong>Status: </strong> <span class="status">{{ ucfirst($schedule->status) }}</span></p>
            <p><strong>Remarks: </strong> {{ $schedule->remarks }}</p>
            <p>
                @if($schedule->status == 'passed')
                    Congratulations! Your dormitory is now **accredited**.
                @else
                    Unfortunately, your dormitory requires **re-evaluation**.
                @endif
            </p>
            <p>Thank you for your application.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Dormitory Accreditation System
        </div>
    </div>
</body>
</html>
