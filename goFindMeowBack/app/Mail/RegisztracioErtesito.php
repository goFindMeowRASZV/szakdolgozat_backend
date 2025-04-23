<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName, $verifyUrl;
    public $headerImageCid;
    private $headerImagePath;

    public function __construct($userName, $verifyUrl, $headerImagePath)
    {
        $this->userName = $userName;
        $this->verifyUrl = $verifyUrl;
        $this->headerImagePath = $headerImagePath;
    }

    public function build()
    {
        $this->withSwiftMessage(function ($message) {
            $message->embed($this->headerImagePath, 'header_img');
        });

        return $this->view('emails.verify')
            ->subject('Email megerősítés – Go Find Meow')
            ->from('info.gofindmeow@gmail.com', 'Go Find Meow')
            ->with([
                'userName' => $this->userName,
                'verifyUrl' => $this->verifyUrl,
            ]);
    }
}
