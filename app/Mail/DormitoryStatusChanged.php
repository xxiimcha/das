<?php

namespace App\Mail;

use App\Models\Dormitory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DormitoryStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $dormitory;
    public $status;
    public $additionalInfo;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Dormitory $dormitory
     * @param string $status
     * @param string $additionalInfo
     */
    public function __construct(Dormitory $dormitory, $status, $additionalInfo)
    {
        $this->dormitory = $dormitory;
        $this->status = $status;
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Dormitory Status Updated')
                    ->view('emails.dormitory-status-changed');
    }
}
