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
        $request->validate([
            'report_id' => 'required|exists:reports,id',
        ]);

        $report = Report::find($request->report_id);

        // Ellenőrizzük, hogy a bejelentés már nincs-e befogva
        if (ShelteredCat::where('report_id', $request->report_id)->exists()) {
            return response()->json(['message' => 'Ez a macska már be van fogva.'], 400);
        }

        $shelterCat = ShelteredCat::create([
            'report_id' => $report->id,
            'mentor_id' => Auth::id(),  // Bejelentkező mentő azonosítója
            'arrival_date' => now(),
            'status' => 'bent',
        ]);

        return response()->json(['message' => 'Macska befogadva.', 'shelterCat' => $shelterCat], 201);
    }
    
    public function show(string $id)
    {
        return ShelteredCat::find($id);
    }
    
    public function update(Request $request, string $id)
    {
        $record = ShelteredCat::find($id);
        $record->fill($request->all());
        $record->save();
    }
    
    public function destroy(string $id)
    {
        ShelteredCat::find($id)->delete();
    }
    
}
