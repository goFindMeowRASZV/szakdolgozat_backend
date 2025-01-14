<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::all(); 
    }

 
    public function store(Request $request)
    {
        $record = new Comment();
        $record->fill($request->all()); 
        $record->save(); 

    }

    
    public function show(string $user_id,$report_id )
    {
        $user = Comment::where('user', $user_id)
        ->where('report', $report_id)
        ->get();
        return $user[0]; 

    }

    public function update(Request $request, string $user_id,$report_id )
    {
        $record = $this->show($user_id, $report_id);
        $record->fill($request->all());
        $record->save();

    }

    public function destroy(string $user_id, $report_id)
    {
        $this->show($user_id, $report_id)->delete(); 
    }
}
