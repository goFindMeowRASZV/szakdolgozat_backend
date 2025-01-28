<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{
    public function store(Request $request): Response
    {
        //VALIDALAS MINDENHOVA!!!
        $request->validate([
            'content' => ['required', 'string','max:250'],
            'photo' => ['required', 'string','max:250']
        ]);


        $comment = Comment::create([
            'content' => $request->content,
            'photo' => $request->photo
        ]);

        $comment->save();
        return response()->noContent();
    }


    //kommentek adott bejelenteshez
    public function kommentek_bejelentes($reportId)
    {
        $comments = DB::table('comments')
            ->select('user','content', 'photo')
            ->where('report', '=', $reportId)
            ->get();
        return $comments;
    }
}
