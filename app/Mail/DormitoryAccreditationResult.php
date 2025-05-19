<?php
namespace App\Mail;

use App\Models\Dormitory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class DormitoryAccreditationResult extends Mailable
{
    use Queueable, SerializesModels;

    public $dorm;
    public $pdfPath;

    public function __construct(Dormitory $dorm, $pdfPath = null)
    {
        $this->dorm = $dorm;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        $email = $this->subject('Dormitory Accreditation Result')
                      ->markdown('emails.dormitory.result');

        if ($this->pdfPath) {
            $email->attach(Storage::path("public/{$this->pdfPath}"), [
                'as' => 'Certification.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}
