<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $roleMap = [
            'admin' => 0,
            'staff' => 1,
            'user'  => 2,
        ];

        $allowedRoles = array_map(fn($r) => $roleMap[$r] ?? null, $roles);

        if (!Auth::check() || !in_array(Auth::user()->role, $allowedRoles)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
