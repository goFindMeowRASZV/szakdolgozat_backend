<?php

namespace App\Http\Controllers;

use App\Models\ShelterCat;
use Illuminate\Http\Request;

class ShelterCatController extends Controller
{
    public function index()
    {
        return ShelterCat::all(); 
    }

 
    public function store(Request $request)
    {
        $record = new ShelterCat();
        $record->fill($request->all()); 
        $record->save(); 

    }

    
    public function show(string $id)
    {
        $user = ShelterCat::where('cat_id', $id)
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
