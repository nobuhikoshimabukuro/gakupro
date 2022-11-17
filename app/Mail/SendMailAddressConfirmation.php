<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailAddressConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $password;
    public $subject;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url , $password, $subject)
    {
        $this->url = $url;
        $this->password = $password;
        $this->subject = $subject;
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->view('recruitproject.mails.mailaddress_confirmation')
        ->subject($this->subject)
        ->with(['url' => "url" , 'password' => "password"]); 

    }
}
