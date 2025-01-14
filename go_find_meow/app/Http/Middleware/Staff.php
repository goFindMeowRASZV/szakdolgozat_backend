<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Staff
{
    
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !(Auth::user()->role === 1)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $next($request); //folytatódhat a kérés

}
