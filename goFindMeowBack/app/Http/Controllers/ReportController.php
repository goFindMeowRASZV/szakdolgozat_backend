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

        $reports = Report::when(in_array($role, [0, 1]), function ($query) {
            // Admin és staff: minden státuszt lát, beleértve az "m"-et is
            return $query->whereIn('status', ['l', 't', 'k', 'm']);
        })
            ->when($role == 2, function ($query) {
                // User: csak l, t, k státuszt és aktívakat lát
                return $query->whereIn('status', ['l', 't', 'k'])
                    ->where('activity', '1');
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
            'address' => 'required|string|max:500',
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





    public function updateReport(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $validated = $request->validate([
            'status' => 'nullable|string|max:1',
            'color' => 'nullable|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'other_identifying_marks' => 'nullable|string|max:250',
            'health_status' => 'nullable|string|max:250',
            'chip_number' => 'nullable|numeric',
            'circumstances' => 'nullable|string|max:250',
            'number_of_individuals' => 'nullable|integer',
            'disappearance_date' => 'nullable|date',
            'photo' => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'activity' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            $filename = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('uploads'), $filename);
            $validated['photo'] = '/uploads/' . $filename;
        }

        $report->update($validated);

        // Friss adat betöltése és visszaküldése
        $report->refresh();
        return response()->json([
            'message' => 'Bejelentés frissítve.',
            'report' => $report
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $user = Auth::user();
        $role = $user->role;

        $query = Report::query();

        // Admin és staff minden státuszt lát
        if (in_array($role, [0, 1])) {
            $query->whereIn('status', ['l', 't', 'k', 'm']);
        } else {
            $query->whereIn('status', ['l', 't', 'k'])
                ->where('activity', 1);
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('status', 'like', "%$keyword%")
                    ->orWhere('address', 'like', "%$keyword%")
                    ->orWhere('color', 'like', "%$keyword%")
                    ->orWhere('pattern', 'like', "%$keyword%")
                    ->orWhere('other_identifying_marks', 'like', "%$keyword%")
                    ->orWhere('health_status', 'like', "%$keyword%")
                    ->orWhere('chip_number', 'like', "%$keyword%")
                    ->orWhere('circumstances', 'like', "%$keyword%")
                    ->orWhere('number_of_individuals', 'like', "%$keyword%")
                    ->orWhere('disappearance_date', 'like', "%$keyword%")
                    ->orWhere('creator_id', 'like', "%$keyword%");
            });
        }

        $results = $query->get();

        return response()->json($results);
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
