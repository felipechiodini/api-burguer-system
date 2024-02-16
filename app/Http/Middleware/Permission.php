<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    public function handle(Request $request, Closure $next, String $permission): Response
    {
        if (!auth()->user()->can($permission)) {
            return response()->json(['dwa'], 401);
        }

        return $next($request);
    }
}
