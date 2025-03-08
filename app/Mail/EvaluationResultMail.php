<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Dormitory;
use App\Models\AccreditationSchedule;

class EvaluationResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dormitory;
    public $schedule;

    public function __construct(Dormitory $dormitory, AccreditationSchedule $schedule)
    {
        $this->dormitory = $dormitory;
        $this->schedule = $schedule;
    }

    public function build()
    {
        return $this->subject('Dormitory Accreditation Result')
                    ->view('emails.evaluation-result');
    }
}
