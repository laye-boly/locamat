<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LocationOrder extends Mailable
{
    private $link;
    private $sub;
    private $recever;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $subject)
    {
        $this->link = $link;
        $this->sub = $subject;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('laye@locatmat.com', $this->sub)
                ->view('emails.order')->with( ['link' => $this->link ]);
    }
}
