<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Personals\Ad\Ad;

class BanAd extends Mailable
{
    use Queueable, SerializesModels;

    public $ad;


    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }


    public function build()
    {
        return $this->to($this->ad->author_email)
            ->markdown('emails.banAdMd')
            ->text('emails.banAdPlain');
    }
}
