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
        $user = Auth::user();
        $role = $user->role;

        $reports = Report::whereIn('status', ['l', 't', 'k'])
            ->when(in_array($role, [0, 1]), function ($query) {
                return $query;
            })
            ->when($role == 2, function ($query) {
                return $query->where('activity', '1');
            })
            ->get();

        return response()->json($reports);
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
            'address' => 'required|string|max:255',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
            'color' => 'required|string',
            'pattern' => 'required|string',
            'other_identifying_marks' => 'nullable|string|max:250',
            'health_status' => 'nullable|string|max:250',
            'chip_number' => 'nullable|numeric',
            'circumstances' => 'nullable|string|max:250',
            'number_of_individuals' => 'nullable|integer',
            'disappearance_date' => 'nullable|date',
            'activity' => 'required|integer'
        ]);


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
            'lat' => $validatedData['lat'] ?? null,
            'lon' => $validatedData['lon'] ?? null,
            'color' => $validatedData['color'],
            'pattern' => $validatedData['pattern'],
            'other_identifying_marks' => $validatedData['other_identifying_marks'] ?? null,
            'health_status' => $validatedData['health_status'] ?? null,
            'photo' => $imagePath,
            'chip_number' => $validatedData['chip_number'] ?? null,
            'circumstances' => $validatedData['circumstances'] ?? null,
            'number_of_individuals' => $validatedData['number_of_individuals'] ?? null,
            'disappearance_date' => $validatedData['disappearance_date'] ?? null,
            'activity' => $validatedData['activity']
        ]);

        return response()->json(['message' => 'Macska bejelentve', 'report' => $report], 201);
    }



    public function get_sheltered_reports()
    {
        $reports = DB::table('reports as r')
            ->join('sheltered_cats as sc', 'sc.report', '=', 'r.report_id')
            ->get();
        return $reports;
    }


    public function get_sheltered_reports_filter($color, $pattern)
    {
        $color = ($color === "*" || empty(trim($color))) ? null : trim($color);
        $pattern = ($pattern === "*" || empty(trim($pattern))) ? null : trim($pattern);


        // Lekérdezés a megfelelő szűrők alkalmazásával
        $reports = DB::table('reports as r')
            ->join('sheltered_cats as sc', 'r.report_id', '=', 'sc.report')
            ->whereIn('r.status', ['m'])
            ->when($color, function ($query) use ($color) {
                return $query->where('r.color', 'LIKE', "%$color%");
            })
            ->when($pattern, function ($query) use ($pattern) {
                return $query->where('r.pattern', 'LIKE', "%$pattern%");
            })

            ->get();

        return response()->json($reports);
    }


    public function get_reports_filter($status, $color, $pattern)
    {
        $status = ($status === "*" || empty(trim($status))) ? null : trim($status);
        $color = ($color === "*" || empty(trim($color))) ? null : trim($color);
        $pattern = ($pattern === "*" || empty(trim($pattern))) ? null : trim($pattern);


        $reports = DB::table('reports as r')
            ->whereIn('r.status', ['l', 'k', 't'])
            ->when($status, function ($query) use ($status) {
                return $query->where('r.status', 'LIKE', "%$status%");
            })
            ->when($color, function ($query) use ($color) {
                return $query->where('r.color', 'LIKE', "%$color%");
            })
            ->when($pattern, function ($query) use ($pattern) {
                return $query->where('r.pattern', 'LIKE', "%$pattern%");
            })

            ->get();

        return response()->json($reports);
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

    public function archive($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json(['error' => 'Bejelentés nem található.'], 404);
        }

        $report->activity = 0;
        $report->save();

        return response()->json(['message' => 'Bejelentés archiválva.']);
    }


    public function get_map_reports()
    {
        $reports = \App\Models\Report::whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('activity', 1)
            ->get();

        return response()->json($reports);
    }


    //commit
}
