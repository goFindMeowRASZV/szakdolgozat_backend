<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    
    public function store(Request $request): Response
    {
    
        $report = Report::create([

            'name' => $request->name,
            'status' => $request->status,
            'address' => $request-> address,
            'color' => $request -> color,
            'pattern' => $request -> pattern,
            'other_identifying_marks' => $request -> other_identifying_marks,
            'needs_help'=> $request -> needs_help,
            'health_status'=> $request -> health_status,
            'photo'=> $request -> photo ,
            'chip_number'=> $request -> chip_number ,
            'circumstances'=> $request -> circumstances ,
            'number_of_individuals'=> $request -> number_of_individuals ,
            'disappearance_date'=> $request -> disappearance_date
        ]);

        event(new $report);

        return response()->noContent();
    }
}
