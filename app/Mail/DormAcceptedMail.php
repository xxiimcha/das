<?php

namespace App\Mail;

use App\Models\Dormitory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DormAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dorm;

    public function __construct(Dormitory $dorm)
    {
        $this->dorm = $dorm;
    }

    public function build()
    {
        return $this->subject('Dormitory Invitation Accepted')
            ->view('emails.dorm_accepted');
    }
}
