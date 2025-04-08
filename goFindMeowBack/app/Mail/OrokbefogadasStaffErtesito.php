<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrokbefogadasStaffErtesito extends Mailable
{
    use Queueable, SerializesModels;

    public $userName, $userEmail, $userMessage;
    public $catImagePath, $catColor, $catPattern, $catInfo;
    public $reportId;
    public $userImagePath;

    public function __construct($userName, $userEmail, $userMessage, $catImagePath, $catColor, $catPattern, $catInfo, $reportId, $userImagePath)
    {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->userMessage = $userMessage;
        $this->catImagePath = $catImagePath;
        $this->catColor = $catColor;
        $this->catPattern = $catPattern;
        $this->catInfo = $catInfo;
        $this->reportId = $reportId;
        $this->userImagePath = $userImagePath;
    }

    public function build()
    {
        return $this->view('emails.staff-orokbefogadas')
            ->subject('Új örökbefogadási jelentkezés érkezett')
            ->from('info.gofindmeow@gmail.com', 'Go Find Meow')
            ->with([
                'userName' => $this->userName,
                'userEmail' => $this->userEmail,
                'userMessage' => $this->userMessage,
                'catImagePath' => $this->catImagePath,
                'catColor' => $this->catColor,
                'catPattern' => $this->catPattern,
                'catInfo' => $this->catInfo,
                'reportId' => $this->reportId,
                'userImagePath' => $this->userImagePath,
            ]);
    }
}

