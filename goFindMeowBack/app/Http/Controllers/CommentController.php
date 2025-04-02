<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::all();
    }

    public function show(string $id)
    {
        return Comment::find($id);
    }


    public function update(Request $request, string $id)
    {
        $record = Comment::find($id);
        $record->fill($request->all());
        $record->save();
    }

    public function destroy(string $id)
    {
        Comment::find($id)->delete();
    }

    public function store(Request $request)
    {
        $request->validate([
            'report' => ['required', 'exists:reports,report_id'],
            'user' => ['required', 'exists:users,id'],
            'content' => ['required', 'string', 'max:250'],
            'photo' => ['nullable', 'image', 'max:2048'], // fájlként jön
        ]);

        $photoUrl = null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('comment_photos', 'public');
            $photoUrl = asset('storage/' . $path);
        }

        $comment = Comment::create([
            'report' => $request->report,
            'user' => $request->user,
            'content' => $request->content,
            'photo' => $photoUrl,
        ]);

        return response()->json($comment, 201);
    }

    public function get_user_comments($userId)
    {
        $user = User::with('comments')->findOrFail($userId);
        return response()->json($user->comments);
    }

    public function getCommentsByReport($reportId)
{
    $comments = Comment::where('report', $reportId)
        ->with('user')
        ->latest()
        ->get();

    return response()->json($comments);
}

}
