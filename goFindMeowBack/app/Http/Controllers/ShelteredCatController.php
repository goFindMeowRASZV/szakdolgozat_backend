<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShelteredCatController extends Controller
{
    //mentett macskak es kapcsolodo jelentesek
     public function getShelteredCatsWithReports()
     {
         $data = DB::table('sheltered_cats as c')
             ->select('c.cat_id', 'r.status', 'r.address', 'r.creator_id')
             ->join('reports as r', 'c.report', '=', 'r.report_id')
             ->get();
         return $data;
     }
}
