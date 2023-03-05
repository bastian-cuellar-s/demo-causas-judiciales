<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    //Public Variables
    public $dataEmail;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataEmail,$subject)
    {
        $this->dataEmail    = $dataEmail;
        $this->subject      = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sendEmail');
    }
}
