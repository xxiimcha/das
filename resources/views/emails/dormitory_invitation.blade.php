<p>Dear {{ $dormitory->owner->name }},</p>

<p>You are invited to register your dormitory, <strong>{{ $dormitory->name }}</strong>, for accreditation.</p>

<p>If you agree to make your dormitory accredited, click the link below to proceed:</p>

<p>
    <a href="{{ $registrationUrl }}">{{ $registrationUrl }}</a>
</p>

<p><strong>Note:</strong> This link is one-time use and will expire after submission.</p>

<p>Thank you,<br>UNC Dormitory Accreditation Committee</p>
