<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

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
        //VALIDALAS MINDENHOVA!!!
        $request->validate([
            'content' => ['required', 'string', 'max:250'],
            'photo' => ['required', 'string', 'max:250']
        ]);


        $comment = Comment::create([
            'content' => $request->content,
            'photo' => $request->photo
        ]);

        $comment->save();
        return response()->noContent();
    }

    public function get_user_comments($userId)
    {
        $user = User::with('comments')  
                    ->findOrFail($userId);


        return response()->json($user->comments);
    
    }
}
