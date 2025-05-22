<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAccountCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plaintextPassword;

    public function __construct($user, $plaintextPassword)
    {
        $this->user = $user;
        $this->plaintextPassword = $plaintextPassword;
    }

    public function build()
    {
        return $this->subject('Your Account Credentials')
                    ->view('emails.account_credentials');
    }
}
