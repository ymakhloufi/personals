<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Personals\Ad\Ad;

class ReplyAd extends Mailable
{
    use Queueable, SerializesModels;

    public $ad;
    public $name;
    public $phone;
    public $email;
    public $text;


    public function __construct(Ad $ad, string $name, string $phone, string $email, string $message)
    {
        $this->ad    = $ad;
        $this->name  = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->text  = $message;
    }


    public function build()
    {
        return $this->markdown('emails.replyAdMd')->text('emails.replyAdPlain');
    }
}
