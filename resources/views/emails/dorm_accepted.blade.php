<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dormitory Invitation Accepted</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; padding: 40px 0;">

    <table width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
        <tr>
            <td style="background-color: #28a745; padding: 20px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px;">Dormitory Registration Confirmed</h1>
            </td>
        </tr>

        <tr>
            <td style="padding: 30px;">
                <h2 style="color: #333;">Hello {{ $dorm->owner->name }},</h2>

                <p style="font-size: 16px; line-height: 1.6; color: #555;">
                    Your invitation to register the dormitory <strong>{{ $dorm->name }}</strong> has been accepted successfully.
                </p>

                <p style="font-size: 16px; line-height: 1.6; color: #555;">
                    Thank you for completing your registration. Our team will now evaluate your application.
                    Please wait for further updates regarding your evaluation schedule.
                </p>

                <p style="font-size: 16px; color: #555;">If you have any questions, feel free to contact us at any time.</p>

                <p style="margin-top: 30px; font-size: 16px; color: #333;">
                    Best regards,<br>
                    <strong>Dormitory Accreditation Team</strong>
                </p>
            </td>
        </tr>

        <tr>
            <td style="background-color: #f1f1f1; text-align: center; padding: 15px; font-size: 14px; color: #777;">
                &copy; {{ date('Y') }} Dormitory Accreditation System. All rights reserved.
            </td>
        </tr>
    </table>

</body>
</html>
