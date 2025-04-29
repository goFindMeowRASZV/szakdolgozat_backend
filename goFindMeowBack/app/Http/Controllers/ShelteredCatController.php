<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ShelteredCat;
use App\Models\User;
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
            'rescuer' => 'required|exists:users,id', 
            'report' => 'required|exists:reports,report_id', 
            'owner' => 'nullable|exists:users,id',
            'adoption_date' => 'nullable|date', 
            'kennel_number' => 'nullable|integer', 
            'medical_record' => 'nullable|string|max:200',
            's_status' => 'nullable|string|in:a,e,d', 
            'chip_number' => 'nullable|numeric',
            'breed' => 'nullable|string|max:100',
        ]);



        $report = Report::where('report_id', $request->report)->first();
        $report->status = "m";
        $report->save();

        if (ShelteredCat::where('report', $request->report_id)->exists()) {
            return response()->json(['message' => 'Ez a macska már be van fogva.'], 400);
        }


        $shelteredCat = ShelteredCat::create([
            'rescuer' => Auth::id(), 
            'report' => $report->report_id, 
            'owner' => $validatedData['owner'] ?? null, 
            'adoption_date' => $validatedData['adoption_date'] ?? null, 
            'kennel_number' => $validatedData['kennel_number'] ?? null, 
            'medical_record' => $validatedData['medical_record'] ?? null, 
            's_status' => $validatedData['s_status'], 
            'chip_number' => $validatedData['chip_number'] ?? null,
            'breed' => $validatedData['breed'] ?? null, 
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
        's_status' => 'nullable|string|in:a,e,d',//A:Aktív, Ö:Örökbeadva, E:ELpusztult
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
        ->select('sheltered_cats.*', 'reports.status', 'reports.address', 'reports.color', 'reports.pattern', 'reports.other_identifying_marks', 'reports.health_status','reports.photo', 'reports.circumstances', 'reports.chip_number as report_chip', 'reports.number_of_individuals', 'reports.event_date', 'reports.creator_id');


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
              ->orWhere('reports.event_date', 'like', "%$keyword%")
              ->orWhere('reports.creator_id', 'like', "%$keyword%");
        });
    }

    $results = $query->get();

    return response()->json($results);
}
public function orokbeadas(Request $request, $id)
{
    $cat = ShelteredCat::findOrFail($id);

    // Email alapján keresünk user-t
    $user = User::where('email', $request->input('owner_email'))->firstOrFail();

    $cat->s_status = 'o';
    $cat->adoption_date = $request->input('adoption_date');
    $cat->owner = $user->id;

    $cat->save();

    return response()->json(['message' => 'Örökbeadás sikeres']);
}



}
