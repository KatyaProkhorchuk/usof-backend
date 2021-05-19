<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // /Users/kprokhorch/usof/scaffold-api/resources/views/Email/passwordReset.blade.php
    public function build()
    {
        return $this->markdown('Email.passwordReset',['login' => $this->obj->login,
            'link' => $this->obj->link]);
    }
}
