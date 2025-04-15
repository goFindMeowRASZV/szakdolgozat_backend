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

    public function updateShelteredCat(Request $request, $id)
{
    $cat = ShelteredCat::findOrFail($id);

    $validated = $request->validate([
        'owner' => 'nullable|exists:users,id',
        'adoption_date' => 'nullable|date',
        'kennel_number' => 'nullable|integer',
        'medical_record' => 'nullable|string|max:200',
        's_status' => 'nullable|string|in:a,e,d',
        'chip_number' => 'nullable|numeric',
        'breed' => 'nullable|string|max:100',
        'photo' => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('sheltered', 'public');
        $validated['photo'] = '/storage/' . $path;
    }

    $cat->update($validated);
    $cat->refresh(); // újratölti az adatbázisból a friss adatokat
    return response()->json([
        'message' => 'Bejelentés frissítve.',
        'report' => $cat
    ]);
    
}
public function search(Request $request)
{
    $keyword = $request->input('q');
    $query = DB::table('sheltered_cats')
        ->join('reports', 'sheltered_cats.report', '=', 'reports.report_id')
        ->select('sheltered_cats.*', 'reports.status', 'reports.address', 'reports.color', 'reports.pattern', 'reports.other_identifying_marks', 'reports.health_status','reports.photo', 'reports.circumstances', 'reports.chip_number as report_chip', 'reports.number_of_individuals', 'reports.disappearance_date', 'reports.creator_id');


    // Keresés
    if ($keyword) {
        $query->where(function ($q) use ($keyword) {
            $q->where('sheltered_cats.kennel_number', 'like', "%$keyword%")
              ->orWhere('sheltered_cats.medical_record', 'like', "%$keyword%")
              ->orWhere('sheltered_cats.s_status', 'like', "%$keyword%")
              ->orWhere('sheltered_cats.chip_number', 'like', "%$keyword%")
              ->orWhere('sheltered_cats.breed', 'like', "%$keyword%")
              ->orWhere('reports.status', 'like', "%$keyword%")
              ->orWhere('reports.address', 'like', "%$keyword%")
              ->orWhere('reports.color', 'like', "%$keyword%")
              ->orWhere('reports.pattern', 'like', "%$keyword%")
              ->orWhere('reports.other_identifying_marks', 'like', "%$keyword%")
              ->orWhere('reports.health_status', 'like', "%$keyword%")
              ->orWhere('reports.circumstances', 'like', "%$keyword%")
              ->orWhere('reports.number_of_individuals', 'like', "%$keyword%")
              ->orWhere('reports.disappearance_date', 'like', "%$keyword%")
              ->orWhere('reports.creator_id', 'like', "%$keyword%");
        });
    }

    $results = $query->get();

    return response()->json($results);
}



}
