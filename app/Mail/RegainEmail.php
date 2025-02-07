<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegainEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userName;
    protected $password;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $password)
    {
        $this->userName = $userName;
        $this->password = $password;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Your Regain Account Details')
            ->view('email.index')
            ->with([
                'userName' => $this->userName,
                'password' => $this->password
            ]);
    }
}
