@component('mail::message')
# Dormitory Accreditation Result

Dear {{ $dorm->owner->name ?? 'Dormitory Owner' }},

Your dormitory **{{ $dorm->name }}** has completed its evaluation process.

@if ($pdfPath)
We are pleased to inform you that your dormitory has been **accredited**.

You may find your certification attached to this email.
@else
We regret to inform you that your dormitory did **not pass** the accreditation process. You may contact us for further clarification.
@endif

Thank you for participating in the Dormitory Accreditation Program.

Regards,  
**Dormitory Accreditation Committee**
@endcomponent
