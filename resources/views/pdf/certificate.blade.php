<!DOCTYPE html>
<html>
<head>
    <title>Dormitory Accreditation Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 60px;
            line-height: 1.6;
            text-align: center;
        }
        h1 {
            margin-bottom: 30px;
            font-size: 28px;
            text-transform: uppercase;
        }
        .info {
            font-size: 18px;
            margin-top: 20px;
        }
        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <h1>CERTIFICATE OF ACCREDITATION</h1>

    <p>This is to certify that</p>
    <h2>{{ $dorm->name }}</h2>
    <p>Located at: {{ $dorm->formatted_address ?? 'N/A' }}</p>

    <div class="info">
        <p>Has met all required standards for student accommodation.</p>
        <p><strong>Awarded on:</strong> {{ $date }}</p>
        <p><strong>Valid From:</strong> {{ $effective_date }} to {{ $expiration_date }}</p>
    </div>

    <div class="signature">
        <div>
            _________________________<br>
            Director, Student Affairs
        </div>
        <div>
            _________________________<br>
            Dean, Student and Alumni Affairs
        </div>
    </div>
</body>
</html>
