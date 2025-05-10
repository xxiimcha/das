<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dormitory Accreditation Invitation</title>
    <style>
        body {
            background-color: #f6f8fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }
        .email-header {
            background-color: #0d6efd;
            color: #fff;
            padding: 20px 30px;
        }
        .email-header h2 {
            margin: 0;
            font-size: 20px;
        }
        .email-body {
            padding: 30px;
        }
        .email-body p {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .email-body a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .email-footer {
            padding: 20px 30px;
            font-size: 12px;
            color: #6c757d;
            background-color: #f8f9fa;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h2>Dormitory Accreditation Invitation</h2>
        </div>
        <div class="email-body">
            <p>Dear <strong>{{ $dormitory->owner->name }}</strong>,</p>

            <p>You are invited to register your dormitory, <strong>{{ $dormitory->name }}</strong>, for the UNC Dormitory Accreditation Program.</p>

            <p>To proceed with the accreditation process, please click the link below:</p>

            <p>
                <a href="{{ $registrationUrl }}" class="button">Register Dormitory</a>
            </p>

            <p><strong>Note:</strong> This link can be used only once and will expire after submission.</p>

            <p>We look forward to your participation and thank you for supporting our commitment to student welfare and safety.</p>

            <p>Sincerely,<br>
            <strong>UNC Dormitory Accreditation Committee</strong></p>
        </div>
        <div class="email-footer">
            This is an automated message. Please do not reply directly to this email.
        </div>
    </div>
</body>
</html>
