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

        //VALIDALAS MINDENHOVA!!!
        $request->validate([
            'status' => ['required', 'string', 'max:1'],
            'address' => ['required', 'string', 'max:100'],
            'color' => ['required', 'string'],
            'pattern' => ['required', 'string'],
            'other_identifying_marks' => ['required', 'string', 'max:250'],
            'needs_help' => ['required', 'boolean'],
            'health_status' => ['required', 'string', 'max:250'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'chip_number' => ['required', 'bigInteger'],
            'circumstances' => ['required', 'string', 'max:250'],
            'number_of_individuals' => ['required', 'integer'],
            'disappearance_date' => ['required', 'date']
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
}
