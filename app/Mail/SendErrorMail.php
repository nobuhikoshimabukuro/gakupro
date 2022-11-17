<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $Subject;
    public $MailText;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Subject,$MailText)
    {
        $this->Subject = $Subject;
        $this->MailText = $MailText;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->view('mails.errormail')
        ->subject($this->Subject)
        ->with(['MailText' => $this->MailText]); 
    }
}
