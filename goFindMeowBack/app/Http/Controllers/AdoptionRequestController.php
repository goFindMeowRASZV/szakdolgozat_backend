<?php

namespace App\Http\Controllers;

use App\Mail\OrokbefogadasErtesito;
use App\Mail\OrokbefogadasStaffErtesito;
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
            'user_name' => 'nullable|string',
        ]);

        $message = $request->message;

        $report = [
            'report_id' => $request->report_report_id,
            'color' => $request->report_color ?? 'ismeretlen',
            'pattern' => $request->report_pattern ?? 'ismeretlen',
            'photo' => $request->report_photo,
        ];

        $user = [
            'id' => $request->user_id,
            'email' => $request->user_email,
            'name' => $request->user_name ?? 'Kedves felhasználó',
        ];

        $catInfo = [
            'ismerteto' => $request->input('report_jellemzes') ?? '-',
            'egeszseg' => $request->input('report_health') ?? '-',
            'chip' => $request->input('report_chip') ?? '-',
            'korulmeny' => $request->input('report_conditions') ?? '-',
            'datum' => $request->input('report_date') ?? '-',
        ];

        $userImageFilename = $user['profile_picture'] ?? null;

        $defaultImagePath = public_path('kepek/user.jpg');

        $userImagePath = $userImageFilename
            ? storage_path('app/public/profile_pictures/' . $userImageFilename)
            : $defaultImagePath;

        if (!file_exists($userImagePath)) {
            $userImagePath = $defaultImagePath;
        }
        $catImagePath = public_path('uploads/' . basename($report['photo']));
        $headerImagePath = public_path('kepek/emailKep1.jpg');



        try {
            Mail::to($user['email'])->send(new OrokbefogadasErtesito(
                $user['name'],
                $report['color'],
                $report['pattern'],
                $message,
                $catImagePath,
                $headerImagePath
            ));
        } catch (\Throwable $e) {
            Log::error('Nem sikerült elküldeni az örökbefogadási emailt: ' . $e->getMessage());
            return response()->json(['error' => 'Nem sikerült elküldeni az emailt.'], 500);
        }

        try {
            //staff ugyfelszolgalat emailcime
            Mail::to('viktoriaszalkai04@gmail.com')->send(new OrokbefogadasStaffErtesito(
                $user['name'],
                $user['email'],
                $message,
                $catImagePath,
                $report['color'],
                $report['pattern'],
                $catInfo,
                $report['report_id'],
                $userImagePath
            ));
        } catch (\Throwable $e) {
            Log::error('Nem sikerült elküldeni az staff emailt: ' . $e->getMessage());
            return response()->json(['error' => 'Nem sikerült elküldeni az emailt.'], 500);
        }
        return response()->json(['message' => 'Email sikeresen elküldve.']);
    }
}
