<?php

namespace App\Http\Controllers;


use App\Models\ShelteredCat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function uploadPicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:2048'
        ]);

        $user = $request->user();

        // töröljük az előző képet, ha van
        if ($user->profile_picture) {
            Storage::delete($user->profile_picture);
        }

        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = '/storage/' . $path;
        $user->save();

        return response()->json(['profile_picture' => $user->profile_picture]);
    }

    public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed'
    ]);

    $user = $request->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
            'message' => 'A jelenlegi jelszó hibás.',
            'code' => 'INVALID_CURRENT_PASSWORD'
        ], 403);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['message' => 'A jelszó sikeresen megváltozott.']);
}



public function createUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|in:0,1,2',
    ]);

    $currentRole = $request->user()->role;

    if (!in_array($currentRole, [0, 1])) {
        return response()->json(['message' => 'Nincs jogosultság.'], 403);
    }

    // Staff nem hozhat létre admint vagy usert
    if ($currentRole === 1 && $request->role !== 1) {
        return response()->json(['message' => 'Staff csak staffot hozhat létre.'], 403);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return response()->json(['message' => 'Felhasználó létrehozva.', 'user' => $user], 201);
}}