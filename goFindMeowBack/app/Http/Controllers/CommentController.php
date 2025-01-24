<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
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
