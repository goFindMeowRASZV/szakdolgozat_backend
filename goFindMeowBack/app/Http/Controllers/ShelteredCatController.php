<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ShelteredCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShelteredCatController extends Controller
{
    public function index()
    {
        return ShelteredCat::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rescuer' => 'required|exists:users,id', // A mentő személy kötelező, és a `users` táblában léteznie kell.
            'report' => 'required|exists:reports,report_id', // A jelentés kötelező, és a `reports` táblában léteznie kell.
            'owner' => 'nullable|exists:users,id', // A tulajdonos opcionális, ha van, akkor a `users` táblában léteznie kell.
            'adoption_date' => 'nullable|date', // Az örökbefogadás dátuma opcionális, ha megadott, akkor dátum kell.
            'kennel_number' => 'nullable|integer', // A kennel száma opcionális, ha megadott, akkor szám kell.
            'medical_record' => 'nullable|string|max:200', // Az orvosi nyilvántartás opcionális, ha megadott, akkor szöveg és max 200 karakter.
            's_status' => 'nullable|string|in:a,e,d', // A státusz opcionális, de ha megadod, akkor csak "a", "e" vagy "d" értéket vehet fel.
            'chip_number' => 'nullable|numeric', // A chip szám opcionális, ha megadott, akkor szám kell.
            'breed' => 'nullable|string|max:100', // A fajta opcionális, ha megadott, akkor szöveg és max 100 karakter.
        ]);



        $report = Report::where('report_id', $request->report)->first();
        $report->status = "m";
        $report->save();

        // Ellenőrizzük, hogy a bejelentés már nincs-e befogva
        if (ShelteredCat::where('report', $request->report_id)->exists()) {
            return response()->json(['message' => 'Ez a macska már be van fogva.'], 400);
        }


        $shelteredCat = ShelteredCat::create([
            'rescuer' => Auth::id(), // Mentő személy ID-ja, amit a validáció biztosít
            'report' => $report->report_id, // Jelentés ID-ja, amit a validáció biztosít
            'owner' => $validatedData['owner'] ?? null, // Tulajdonos ID-ja, ha van
            'adoption_date' => $validatedData['adoption_date'] ?? null, // Örökbefogadás dátuma, ha van
            'kennel_number' => $validatedData['kennel_number'] ?? null, // Kennel száma, ha van
            'medical_record' => $validatedData['medical_record'] ?? null, // Orvosi nyilvántartás, ha van
            's_status' => $validatedData['status'] ?? null, // Macska állapota (pl. aktív, örökbeadott, elhunyt)
            'chip_number' => $validatedData['chip_number'] ?? null, // Chip szám, ha van
            'breed' => $validatedData['breed'] ?? null, // Fajta, ha van
        ]);

        return response()->json(['message' => 'Macska befogva.', 'report' => $report], 201);
    }

    public function show(string $id)
    {
        return ShelteredCat::find($id);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'owner' => 'nullable|exists:users,id',
            'adoption_date' => 'nullable|date',
            'kennel_number' => 'nullable|integer',
            'medical_record' => 'nullable|string|max:200',
            'chip_number' => 'nullable|numeric',
            'breed' => 'nullable|string|max:100',
        ]);

        $cat = ShelteredCat::findOrFail($id);
        $cat->update($validated);

        return response()->json(['message' => 'Macska adatai frissítve.']);
    }


    public function destroy(string $id)
    {
        ShelteredCat::find($id)->delete();
    }

    public function getShelteredCatsWithDetails()
    {
        $cats = DB::table('sheltered_cats')
            ->join('reports', 'sheltered_cats.report', '=', 'reports.report_id')
            ->select(
                'sheltered_cats.cat_id as macska_id',
                'sheltered_cats.rescuer as mento_id',
                'sheltered_cats.report as bejelentes_id',
                'sheltered_cats.owner as gazdi_id',
                'reports.created_at as behozas_datum',
                'sheltered_cats.adoption_date as kikerules_datum',
                'sheltered_cats.kennel_number as kennelszam',
                'sheltered_cats.medical_record as korlap',
                'sheltered_cats.s_status as statusz',
                'sheltered_cats.chip_number as chip_sz',
                'sheltered_cats.breed as fajta',
                'reports.photo as kep'
            )
            ->get();

        return response()->json($cats);
    }
}
