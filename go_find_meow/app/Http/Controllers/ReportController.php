<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return Report::all(); 
    }

 
    public function store(Request $request)
    {
        $record = new Report();
        $record->fill($request->all()); 
        $record->save(); 

    }

    
    public function show(string $id)
    {
        $user = Report::where('report_id', $id)
        ->get();
        return $user[0]; 

    }

    public function update(Request $request, string $id)
    {
        $record = $this->show($id);
        $record->fill($request->all());
        $record->save();

    }

    public function destroy(string $id)
    {
        $this->show($id)->delete(); 
    }
}
