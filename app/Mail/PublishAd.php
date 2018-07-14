<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Personals\Ad\Ad;

class PublishAd extends Mailable
{
    use Queueable, SerializesModels;

    public $ad;


    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.publishAdMd')->text('emails.publishAdPlain');
    }
}
