<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Dormitory;

class DormitoryInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $dormitory;
    public $registrationUrl;

    public function __construct(Dormitory $dormitory, $registrationUrl)
    {
        $this->dormitory = $dormitory;
        $this->registrationUrl = $registrationUrl;
    }

    public function build()
    {
        return $this->subject('Invitation to Register Dormitory')
                    ->view('emails.dormitory_invitation');
    }
}
