<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dormitory Accreditation Invitation</title>
    <style>
        body {
            background-color: #ffffff;
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
            border: 1px solid #d9534f;
            overflow: hidden;
        }
        .email-header {
            background-color: #b71c1c;
            color: #fff;
            padding: 20px 30px;
        }
        .email-header h2 {
            margin: 0;
            font-size: 22px;
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
            background-color: #b71c1c;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .email-footer {
            padding: 20px 30px;
            font-size: 12px;
            color: #a0a0a0;
            background-color: #f9f9f9;
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

            <p>We are pleased to invite you to register your dormitory, <strong>{{ $dormitory->name }}</strong>, for the UNC Dormitory Accreditation Program under the Office of Student Affairs at the University of Nueva Caceres.</p>

            <p>This program ensures that dormitories meet our standards for safety, sanitation, and student welfare.</p>

            <p><strong>Program Overview:</strong></p>
            <ol>
                <li><strong>Register Your Dormitory</strong><br>• Fill out the online registration form with details about your facility.</li>
                <li><strong>On-Site Inspection</strong><br>• A committee member will visit your dormitory for verification.</li>
                <li><strong>Final Evaluation & Approval</strong><br>• We will review results and issue your certificate if qualified.</li>
            </ol>

            <p>To proceed with the accreditation process, click the button below:</p>

            <p>
                <a href="{{ $registrationUrl }}" class="button">Register Dormitory</a>
            </p>

            <p><strong>Note:</strong> This link is single-use and will expire after submission.</p>

            <p>Thank you for supporting our commitment to excellence in student housing.</p>

            <p>Sincerely,<br>
            <strong>UNC Dormitory Accreditation Committee</strong></p>
        </div>
        <div class="email-footer">
            This is an automated message. Please do not reply directly to this email.
        </div>
    </div>
</body>
</html>
