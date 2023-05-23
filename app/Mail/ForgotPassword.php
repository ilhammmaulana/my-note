<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $dataUser, $email, $otp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $dataUser, $otp)
    {
        $this->dataUser = $dataUser;
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('otp', ["otp" => $this->otp]);
    }
}
