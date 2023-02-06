<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailAddressConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $destination_name;
    public $url;    
    public $password;
    
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject , $destination_name , $url , $password)
    {
        $this->subject = $subject;
        $this->destination_name = $destination_name;
        $this->url = $url;        
        $this->password = $password;
      
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
        ->with(['destination_name' => "destination_name" , 'url' => "url" , 'password' => "password"]); 

    }
}
