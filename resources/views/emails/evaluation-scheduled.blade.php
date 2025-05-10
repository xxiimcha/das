<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dormitory Evaluation Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f8fa;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 30px auto;
            padding: 30px;
            border: 1px solid #e1e4e8;
            border-radius: 8px;
        }
        .header {
            background-color: #dc3545;
            color: #ffffff;
            padding: 15px 30px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .header h2 {
            margin: 0;
        }
        .content {
            padding: 20px 30px;
            color: #333333;
        }
        .footer {
            padding: 15px 30px;
            font-size: 13px;
            color: #6c757d;
            text-align: center;
        }
        .details-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .details-table th,
        .details-table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Dormitory Evaluation Scheduled</h2>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $dormitory->owner->name }}</strong>,</p>

            <p>We are pleased to inform you that your dormitory has been scheduled for an evaluation. Below are the details:</p>

            <table class="details-table">
                <tr>
                    <th>Dormitory Name</th>
                    <td>{{ $dormitory->name }}</td>
                </tr>
                <tr>
                    <th>Evaluation Date</th>
                    <td>{{ \Carbon\Carbon::parse($evaluationDate)->format('F j, Y') }}</td>
                </tr>
            </table>

            <p>If you have any questions or require additional information, please do not hesitate to contact us.</p>

            <p>Best regards,<br>
            <strong>Accreditation Committee</strong></p>
        </div>
        <div class="footer">
            This is an automated message. Please do not reply to this email.
        </div>
    </div>
</body>
</html>
