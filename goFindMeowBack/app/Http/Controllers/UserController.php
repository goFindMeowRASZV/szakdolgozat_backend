<?php

namespace App\Http\Controllers;


use App\Models\ShelteredCat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $record = new User();
        $record->fill($request->all());
        $record->save();
    }

    public function show(string $id)
    {
        return User::find($id);
    }
    public function update(Request $request, string $id)
    {
        $record = User::find($id);
        $record->fill($request->all());
        $record->save();
    }
    public function destroy(string $id)
    {
        User::find($id)->delete();
    }

    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "password" => 'string|min:3|max:50'
        ]);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }
        $user = User::where("id", $id)->update([
            "password" => Hash::make($request->password),
        ]);
        return response()->json(["user" => $user]);
    }

    
}
