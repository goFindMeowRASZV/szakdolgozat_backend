<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrokbefogadasErtesito extends Mailable
{
    use Queueable, SerializesModels;

    public $userName, $catColor, $catPattern, $userMessage;
    public $catImageCid, $headerImageCid;
    private $catImagePath, $headerImagePath;

    public function __construct($userName, $catColor, $catPattern, $userMessage, $catImagePath, $headerImagePath)
    {
        $this->userName = $userName;
        $this->catColor = $catColor;
        $this->catPattern = $catPattern;
        $this->userMessage = $userMessage;

        $this->catImagePath = $catImagePath;
        $this->headerImagePath = $headerImagePath;
    }

    public function build()
{
    return $this->view('emails.orokbefogadas')
        ->subject('Örökbefogadási jelentkezésed megérkezett – Go Find Meow')
        ->from('info.gofindmeow@gmail.com', 'Go Find Meow')
        ->with([
            'userName' => $this->userName,
            'catColor' => $this->catColor,
            'catPattern' => $this->catPattern,
            'userMessage' => $this->userMessage,
            'catImagePath' => $this->catImagePath,
            'headerImagePath' => $this->headerImagePath,
        ]);
}
}
