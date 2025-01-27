<!DOCTYPE html>
<html>
<head>
    <title>Dormitory Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .email-header {
            background-color: #dc3545;
            color: #ffffff;
            text-align: center;
            padding: 15px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 20px;
        }
        .email-body {
            padding: 20px;
            color: #333333;
        }
        .email-body p {
            margin: 10px 0;
            line-height: 1.6;
        }
        .email-body .highlight {
            font-weight: bold;
            color: #dc3545;
        }
        .email-footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666666;
        }
        .button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            font-size: 14px;
            text-decoration: none;
            color: #ffffff;
            background-color: #dc3545;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Dormitory Status Updated</h1>
        </div>
        <div class="email-body">
            <p>Dear {{ $dormitory->owner->name }},</p>
            <p>We are writing to inform you that the status of your dormitory <span class="highlight">{{ $dormitory->name }}</span> has been updated to <span class="highlight">{{ ucfirst($status) }}</span>.</p>

            @if ($status === 'approved')
                <p>The evaluation/accreditation date has been scheduled for <span class="highlight">{{ $additionalInfo }}</span>.</p>
                <p>Kindly ensure that all necessary preparations are made before this date.</p>
            @elseif ($status === 'declined')
                <p>The reason for the decline is as follows:</p>
                <blockquote style="border-left: 4px solid #dc3545; padding-left: 10px; margin-left: 0; color: #555555;">
                    {{ $additionalInfo }}
                </blockquote>
                <p>If you have any questions or need clarification, please contact us.</p>
            @endif

            <p>Thank you for your cooperation.</p>
            <p>Best regards,</p>
            <p><strong>The Committee Team</strong></p>

            <a href="{{ url('/') }}" class="button">Visit Our Platform</a>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Dormitory Accreditation System. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
