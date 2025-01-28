<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function store(Request $request): Response
    {

        //VALIDALAS MINDENHOVA!!!
        $request->validate([
            'status' => ['required', 'string', 'max:1'],
            'address' => ['required', 'string','max:100'],
            'color' => ['required', 'string'],
            'pattern' => ['required', 'string'],
            'other_identifying_marks' =>['required', 'string','max:250'],
            'needs_help' => ['required','boolean'],
            'health_status' => ['required', 'string','max:250'],
            'photo' => ['required', 'string','max:500'],
            'chip_number' => ['required', 'bigInteger'],
            'circumstances' => ['required', 'string','max:250'],
            'number_of_individuals' => ['required','integer'],
            'disappearance_date' => ['required','date']
        ]);


        $report = Report::create([
            'status' => $request->status,
            'address' => $request->address,
            'color' => $request->color,
            'pattern' => $request->pattern,
            'other_identifying_marks' => $request->other_identifying_marks,
            'needs_help' => $request->needs_help,
            'health_status' => $request->health_status,
            'photo' => $request->photo,
            'chip_number' => $request->chip_number,
            'circumstances' => $request->circumstances,
            'number_of_individuals' => $request->number_of_individuals,
            'disappearance_date' => $request->disappearance_date
        ]);

        $report->save();
        return response()->noContent();
    }


    // bejelentesek statusz alapjan
    public function bejelentes_statusz($status)
    {
        $reports = DB::table('reports')
            ->where('status', '=', $status)
            ->get();
        return $reports;
    }

    // bejelentesek szama statusz szerint
    public function bejelentesek_szama_statusz()
    {
        $reports = DB::table('reports')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
        return $reports;
    }

    //macskak statusz szin es minta alapjan
    public function getCatsByStatusColorPattern($status, $color, $pattern)
    {
        $cats = DB::table('sheltered_cats as c')
            ->join('reports as r', 'c.report', '=', 'r.report_id')
            ->where('c.status', '=', $status)
            ->where('r.color', '=', $color)
            ->where('r.pattern', '=', $pattern)
            ->get();
        return $cats;
    }


    //User.phpban withes 
    public function felhasznalok_bejelentesei()
    {
        $users = User::with('reports')
            ->get(['id', 'name', 'email']);

        return $users;
    }


    public function felhasznal_kereses_bejelentes()
    {
        $users = User::with(['reports' => function ($query) {
            $query->where('status', '=', 'K');  // K- keresem
        }])
            ->get(['id', 'name', 'email']);  

        return $users;
    }
}
