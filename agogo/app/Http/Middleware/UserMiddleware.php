<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            return $next($request); // Allow the request to proceed
        }

        // Redirect or handle unauthorized access for non-admin users
        return redirect('student.login')->with('error', 'Unauthorized access.');
    }
}
