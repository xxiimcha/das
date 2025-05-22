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

            <p>I hope this message finds you well.</p>

            <p>At the Office of Student Affairs in the University of Nueva Caceres, we are pleased to invite you to register your dormitory, <strong>{{ $dormitory->name }}</strong>, as part of the UNC Dormitory Accreditation Program. Our mission is to support students, encourage innovation, and uphold the highest standard of academic integrity.</p>

            <h4>Program Overview</h4>
            <p>Your dormitory’s accreditation will consist of three simple steps:</p>

            <ol>
                <li><strong>Register Your Dormitory</strong><br>
                • Complete the online registration form with basic details about your facility.</li>

                <li><strong>On-Site Inspection</strong><br>
                • A member of our Accreditation Committee will visit to verify that your dorm meets our safety, sanitation, and facility standards.</li>

                <li><strong>Final Evaluation &amp; Approval</strong><br>
                • We’ll review inspection findings and formally issue your accreditation certificate once all criteria are met.</li>
            </ol>

            <p>Upon successful completion, your dormitory accreditation will be valid for one year before re-accreditation of the dormitory.</p>

            <p>To begin, kindly proceed to the registration link below:</p>

            <p>
                <a href="{{ $registrationUrl }}">{{ $registrationUrl }}</a>
            </p>

            <p><strong>Note:</strong> This link is one-time use and will expire after submission.</p>

            <p>Thank you,<br>
            UNC Dormitory Accreditation Committee</p>


            <a href="{{ url('/') }}" class="button">Visit Our Platform</a>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Dormitory Accreditation System. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
