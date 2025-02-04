<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function store(Request $request): Response
    {

        $request->validate([
            'photo' => 'nullable|mimes:jpg,png,gif,jpeg,svg |max:2048',
           
        ]);
        $file = $request->file('photo');   // fájl nevének lekérése  
        $extension = $file->getClientOriginalName(); //kiterjesztés
        $imageName = time() . '.' . $extension; // a kép neve az időbéjegnek köszönhetően egyedi lesz. 
        $file->move(public_path('kepek'), $imageName); //átmozgatjuk a public mappa kepek könyvtárába 
        $kepek = new Report(); // Létrehozzuk a kép objektumot. 
        $kepek-> photo = 'kepek/' . $imageName; // megadjuk az új fájl elérési utját
        $kepek->save(); //elmentjük
       

        //VALIDALAS MINDENHOVA!!!
        $request->validate([
            'report_id' => ['required', 'integer'],
            'creator_id' => ['required','integer'],
            'status' => ['required', 'string', 'max:1'],
            'expiration_date' => ['required', 'date'],
            'address' => ['required', 'string', 'max:100'],
            'latitude' => ['nullable', 'float'],
            'longitude' => ['nullable', 'float'],
            'color' => ['required', 'array'],
            'pattern' => ['required', 'array'],
            'other_identifying_marks' => ['nullable', 'string', 'max:250'],
            'needs_help' => ['nullable', 'boolean'],
            'health_status' => ['nullable', 'string', 'max:250'],
            /* 'photo' => ['nullable', 'string'], */
            'chip_number' => ['nullable', 'numeric'],
            'circumstances' => ['nullable', 'string', 'max:250'],
            'number_of_individuals' => ['nullable', 'integer'],
            'disappearance_date' => ['nullable', 'date']
        ]);


        $report = Report::create([
            'report_id'=> $request-> report_id,
            'creator_id' =>$request -> creator_id,
            'status' => $request->status,
            'expiration_date' => $request-> expiration_date,
            'address' => $request->address,
            'latitude' => $request -> latitude,
            'longitude'=> $request -> longitude,
            'color' => json_encode($request->color),  // színek mentése JSON-ként
            'pattern' => json_encode($request->pattern),  // minták mentése JSON-ként
            'other_identifying_marks' => $request->other_identifying_marks,
            'needs_help' => $request->needs_help,
            'health_status' => $request->health_status,
            'photo' => $imageName,
            'chip_number' => $request->chip_number,
            'circumstances' => $request->circumstances,
            'number_of_individuals' => $request->number_of_individuals,
            'disappearance_date' => $request->disappearance_date
        ]);

        $report->save();
        return response()->noContent();
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
}
