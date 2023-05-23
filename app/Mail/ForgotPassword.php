<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $idUser, $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idUser, $email)
    {
        $this->idUser = $idUser;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('otp', ["otp" => "283290"]);
    }
}
