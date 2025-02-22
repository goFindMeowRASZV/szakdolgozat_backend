<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ShelteredCat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{

    public function index()
    {
        return Report::all();
    }

    public function show(string $id)
    {
        return Report::find($id);
    }

    public function update(Request $request, string $id)
    {
        $record = Report::find($id);
        $record->fill($request->all());
        $record->save();
    }

    public function destroy(string $id)
    {
        Report::find($id)->delete();
    }

    public function store(Request $request): JsonResponse
    {
        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        if (!Auth::check()) {
            return response()->json(['error' => 'No user logged in.'], 401);
        }

        $creatorId = Auth::id();

        // Validáció
        $validatedData = $request->validate([
            'photo' => 'nullable|mimes:jpg,png,gif,jpeg,svg|max:2048',
            'status' => 'required|string|max:1',
            'address' => 'required|string|max:100',
            /*  'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric', */
            'color' => 'required|array',
            'pattern' => 'required|array',
            'other_identifying_marks' => 'nullable|string|max:250',
            'health_status' => 'nullable|string|max:250',
            'chip_number' => 'nullable|numeric',
            'circumstances' => 'nullable|string|max:250',
            'number_of_individuals' => 'nullable|integer',
            'disappearance_date' => 'nullable|date'
        ]);



        /* // Ellenőrizzük a 'needs_help' mezőt, ha nincs, alapértelmezett értékként false-t adunk
        $needsHelp = $validatedData['needs_help'] ?? false;
     
        // Ha a needs_help mező 'true' vagy 'false' sztringként van, konvertáljuk logikai értékre
        if (is_string($needsHelp)) {
            $needsHelp = filter_var($needsHelp, FILTER_VALIDATE_BOOLEAN);
        }
      */
        // Fájlkezelés, ha van feltöltött kép
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            $file->move(public_path('uploads'), $imageName);
            $imagePath = url('uploads/' . $imageName);
        }

        // Adatok mentése az adatbázisba
        $report = Report::create([
            'creator_id' => $creatorId,  // Bejelentkezett felhasználó azonosítója
            'status' => $validatedData['status'],
            'address' => $validatedData['address'],
            /* 'latitude' => $validatedData['latitude'] ?? null,
            'longitude' => $validatedData['longitude'] ?? null, */
            'color' => json_encode($validatedData['color']),
            'pattern' => json_encode($validatedData['pattern']),
            'other_identifying_marks' => $validatedData['other_identifying_marks'] ?? null,
            /*   'needs_help' => $needsHelp,  // Itt már logikai értéket tárolunk */
            'health_status' => $validatedData['health_status'] ?? null,
            'photo' => $imagePath,
            'chip_number' => $validatedData['chip_number'] ?? null,
            'circumstances' => $validatedData['circumstances'] ?? null,
            'number_of_individuals' => $validatedData['number_of_individuals'] ?? null,
            'disappearance_date' => $validatedData['disappearance_date'] ?? null
        ]);

        return response()->json(['message' => 'Macska bejelentve', 'report' => $report], 201);
    }



    public function get_color($color)
    {
        $reports = DB::table('reports')
            ->where('color', '=', $color)
            ->get();
        return $reports;
    }

    public function get_pattern($pattern)
    {
        $reports = DB::table('reports')
            ->where('pattern', '=', $pattern)
            ->get();
        return $reports;
    }
    public function get_status($status)
    {
        $reports = DB::table('reports')
            ->where('status', '=', $status)
            ->get();
        return $reports;
    }
    public function get_address($address)
    {
        $reports = DB::table('reports')
            ->where('address', '=', $address)
            ->get();
        return $reports;
    }
    public function get_chip_number($chip_number)
    {
        $reports = DB::table('reports')
            ->where('chip_number', '=', $chip_number)
            ->get();
        return $reports;
    }

    public function get_sheltered_reports()
    {
        $reports = DB::table('reports as r')
            ->join('sheltered_cats as sc', 'sc.report', '=', 'r.report_id')
            ->get();
        return $reports;
    }


    public function get_sheltered_reports_filter($color, $pattern, $date1, $date2)
{
    // Ha a szín vagy minta nem lett kiválasztva, akkor ne szűrjünk rájuk
    if ($color === "*" || $color === null) $color = null;
    if ($pattern === "*" || $pattern === null) $pattern = null;

    // Ha nincs megadva kezdő dátum, alapértelmezett érték
    if ($date1 === null) $date1 = "2015-01-01"; // Alapértelmezett dátum
    if ($date2 === null) $date2 = date("Y-m-d"); // Alapértelmezett dátum: ma

    $reports = DB::table('reports as r')
        ->join('sheltered_cats as sc', 'r.report_id', '=', 'sc.report')
        // Szín szűrés, ha van
        ->when($color, function ($query) use ($color) {
            return $query->where('r.color', 'like', '%' . $color . '%');
        })
        // Minta szűrés, ha van
        ->when($pattern, function ($query) use ($pattern) {
            return $query->where('r.pattern', 'like', '%' . $pattern . '%');
        })
        // Dátum szűrés
        ->where('r.created_at', '>=', $date1)
        ->where('r.created_at', '<=', $date2)
        ->get();

    return $reports->isEmpty() ? response()->json([]) : response()->json($reports);
}

public function get_reports_filter($color, $pattern, $date1, $date2)
{
    if ($color === "*" || $color === null) $color = null;
    if ($pattern === "*" || $pattern === null) $pattern = null;

    if ($date1 === null) $date1 = "2015-01-01";
    if ($date2 === null) $date2 = date("Y-m-d");

    $reports = DB::table('reports as r')
        // Szín szűrés, ha van
        ->when($color, function ($query) use ($color) {
            return $query->where('r.color', 'like', '%' . $color . '%');
        })
        // Minta szűrés, ha van
        ->when($pattern, function ($query) use ($pattern) {
            return $query->where('r.pattern', 'like', '%' . $pattern . '%');
        })
        // Dátum szűrés
        ->where('r.created_at', '>=', $date1)
        ->where('r.created_at', '<=', $date2)
        ->get();

    return $reports->isEmpty() ? response()->json([]) : response()->json($reports);
}





    public function get_sheltered_reports_status($status)
    {
        $reports = DB::table('reports as r')
            ->join('sheltered_cats as sc', 'r.id', '=', 'sc.report_id')
            ->where('r.status', '=', $status)
            ->get();
        return $reports;
    }


    public function get_sheltered_reports_address($address)
    {
        $reports = DB::table('reports as r')
            ->join('sheltered_cats as sc', 'r.report_id', '=', 'sc.report')
            ->where('r.address', '=', $address)
            ->get();
        return $reports;
    }

    public function get_sheltered_reports_chip_number($chip_number)
    {
        $reports = DB::table('reports as r')
            ->join('sheltered_cats as sc', 'r.report_id', '=', 'sc.report')
            ->where('r.chip_number', '=', $chip_number)
            ->get();
        return $reports;
    }

    public function get_reports_photo($report)
    {
        $reports = DB::table('reports as r')
            ->select('photo')
            ->where('r.report_id', '=', $report)
            ->get();
        return $reports;
    }


    public function sheltercat(Request $request)
{
    /* // Ellenőrizzük, hogy létezik-e ilyen report
    $report = Report::find($report_id);
    
    if (!$report) {
        return response()->json(['error' => 'Nincs ilyen bejelentés'], 404);
    }
    public function shelter_cat($report_id)
    {
        // Ellenőrizzük, hogy létezik-e ilyen report
        $report = Report::find($report_id);

        if (!$report) {
            return response()->json(['error' => 'Nincs ilyen bejelentés'], 404);
        }

        // Ellenőrizzük, hogy ez a report már nem került-e menhelyre
        $existingShelteredCat = ShelteredCat::where('report_id', $report_id)->first();

        if ($existingShelteredCat) {
            return response()->json(['error' => 'Ez a macska már menhelyen van'], 400);
        }

        // Új menhelyi macska rekord létrehozása
        $shelteredCat = ShelteredCat::create([
            'report_id' => $report_id
        ]);
    if ($existingShelteredCat) {
        return response()->json(['error' => 'Ez a macska már menhelyen van'], 400);
    }
 */
    // Új menhelyi macska rekord létrehozása
/*     $shelteredCat = ShelteredCat::create([
        'report_id' => $request->report_id
    ]);

        return response()->json([
            'message' => 'A macska menhelyre került!',
            'sheltered_cat' => $shelteredCat
        ], 201);
    } */
}
}