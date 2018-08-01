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


    public function __construct(Ad $ad, string $name, string $phone, string $senderEmail, string $message)
    {
        $this->ad    = $ad;
        $this->name  = $name;
        $this->phone = $phone;
        $this->email = $senderEmail;
        $this->text  = $message;
    }


    public function build()
    {
        return $this->markdown('emails.replyAdMd')
            ->text('emails.replyAdPlain')
            ->replyTo($this->email)
            ->subject("Reply From " . $this->name);
    }
}
