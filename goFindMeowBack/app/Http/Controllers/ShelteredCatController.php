<?php

namespace App\Http\Controllers;

use App\Models\ShelteredCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShelteredCatController extends Controller
{
    public function index()
    {
        return ShelteredCat::all();
    }
    
    public function store(Request $request)
    {
        $record = new ShelteredCat();
        $record->fill($request->all());
        $record->save();
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
