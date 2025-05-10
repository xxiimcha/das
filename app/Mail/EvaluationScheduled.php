<?php
namespace App\Mail;

use App\Models\Dormitory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EvaluationScheduled extends Mailable
{
    use Queueable, SerializesModels;

    public $dormitory;
    public $evaluationDate;

    public function __construct(Dormitory $dormitory, $evaluationDate)
    {
        $this->dormitory = $dormitory;
        $this->evaluationDate = $evaluationDate;
    }

    public function build()
    {
        return $this->subject('Dormitory Evaluation Scheduled')
                    ->view('emails.evaluation-scheduled');
    }
}
