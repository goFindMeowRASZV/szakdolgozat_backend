<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

abstract class Controller
{
    
    public function index()
    {
        return Comment::all(); 
    }

    // mommentek adott bejelenteshez
    public function kommentek_bejelentes($reportId)
    {
        $comments = DB::table('comments')
            ->select('content', 'photo', 'created_at')
            ->where('report', '=', $reportId)
            ->get();
        return $comments;
    }
}
