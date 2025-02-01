<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || empty(Auth::user()->api_token)) {
            Auth::logout();
            return redirect('/doctor/login')->withErrors(['error' => 'Unauthorized access']);
        }

        return $next($request);
    }
}
