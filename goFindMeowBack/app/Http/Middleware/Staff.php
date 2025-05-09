<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Staff
{
   
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !(Auth::user()->role === 1)) {
            return response()->json(['message' => 'Unauthorized'], 403);

    }
    return $next($request); 
}
}