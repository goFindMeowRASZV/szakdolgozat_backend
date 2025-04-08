<?php

namespace App\Http\Controllers;

use App\Models\ShelteredCat;
use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class AdoptionRequestController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:50',
            'report_report_id' => 'required|integer|exists:reports,report_id',
            'report_color' => 'nullable|string',
            'report_pattern' => 'nullable|string',
            'report_photo' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id',
            'user_email' => 'required|email',
        ]);
        
        $message = $request->message;
        $report = [
            'report_id' => $request->report_report_id,
            'color' => $request->report_color,
            'pattern' => $request->report_pattern,
            'photo' => $request->report_photo,
        ];
        $user = [
            'id' => $request->user_id,
            'email' => $request->user_email,
        ];
        

        // ✅ Email visszaigazolás a felhasználónak
        try {
            Mail::raw(
                "Kedves felhasználó!\n\nA(z) \"{$report['color']} / {$report['pattern']}\" cicára küldött örökbefogadási jelentkezésed sikeresen megérkezett. Munkatársaink hamarosan felveszik veled a kapcsolatot.\n\nKöszönjük!\nGoFindMeow",
                fn ($mail) => $mail
                    ->to('roszkopf.adel@gmail.com')
                    ->subject('Örökbefogadási jelentkezés sikeres')
                    ->from('info.gofindmeow@gmail.com', 'GoFindMeow')
            );
        } catch (\Throwable $e) {
            Log::error('Nem sikerült elküldeni a felhasználónak az örökbefogadási emailt: ' . $e->getMessage());
        }

        // ✅ Email értesítés staffnak
        try {
            $staffBody = "Új örökbefogadási jelentkezés érkezett a következő cicára:\n\n"
                . "Szín: {$report['color']}\n"
                . "Minta: {$report['pattern']}\n"
                . "Report ID: {$report['report_id']}\n\n"
                . "Felhasználó ID: {$user['id']}\n"
                . "Email: {$user['email']}\n\n"
                . "Üzenet:\n{$message}";

            Mail::raw(
                $staffBody,
                fn ($mail) => $mail
                    ->to('roszkopf.adel@gmail.com')
                    ->subject('Új örökbefogadási jelentkezés')
                    ->from('info.gofindmeow@gmail.com', 'GoFindMeow')
            );
        } catch (\Throwable $e) {
            Log::error('Nem sikerült elküldeni a staffnak az örökbefogadási emailt: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Az örökbefogadási jelentkezést sikeresen elküldtük.',
        ]);
    }
}