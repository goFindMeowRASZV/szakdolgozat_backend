<?php

namespace App\Http\Controllers;

use App\Models\Report;
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
/*             'expiration_date' => 'nullable|date',
 */            'address' => 'required|string|max:100',
           /*  'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric', */
            'color' => 'required|array',
            'pattern' => 'required|array',
            'other_identifying_marks' => 'nullable|string|max:250',
            /* 'needs_help' => 'nullable|boolean', */
            'health_status' => 'nullable|string|max:250',
            'chip_number' => 'nullable|numeric',
            'circumstances' => 'nullable|string|max:250',
            'number_of_individuals' => 'nullable|integer',
            'disappearance_date' => 'nullable|date'
        ]);

/*         $validatedDate['expiration_date'] = $validatedDate['expiration_date'] ?? Carbon::now()->addDays(14);
 */
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
            $file->move(public_path('kepek'), $imageName);
            $imagePath = asset('kepek/' . $imageName);
        }

        // Adatok mentése az adatbázisba
        Report::create([
            'creator_id' => $creatorId,  // Bejelentkezett felhasználó azonosítója
            'status' => $validatedData['status'],
/*             'expiration_date' => $validatedDate['expiration_date'],
 */            'address' => $validatedData['address'],
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

        return response()->json($request->all());
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
        $reports = DB::table('sheltered_cats as sc')
            ->join('reports as r', 'sc.report_id', '=', 'r.id')
            ->get();
        return $reports;
    }


    public function get_sheltered_reports_color($color)
    {
        $reports = DB::table('reports as r')
            ->join('sheltered_cats as sc', 'r.id', '=', 'sc.report_id')
            ->where('r.color', '=', $color)
            ->get();
        return $reports;
    }


    public function get_sheltered_reports_pattern($pattern)
    {
        $reports = DB::table('reports as r')
            ->join('sheltered_cats as sc', 'r.id', '=', 'sc.report_id')
            ->where('r.pattern', '=', $pattern)
            ->get();
        return $reports;
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
            ->join('sheltered_cats as sc', 'r.id', '=', 'sc.report_id')
            ->where('r.address', '=', $address)
            ->get();
        return $reports;
    }

    public function get_sheltered_reports_chip_number($chip_number)
    {
        $reports = DB::table('reports as r')
            ->join('sheltered_cats as sc', 'r.id', '=', 'sc.report_id')
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
}
