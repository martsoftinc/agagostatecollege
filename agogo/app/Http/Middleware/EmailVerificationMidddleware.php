<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationMidddleware
{
public function handle($request, Closure $next)
{
    $user = auth()->user();
 
    // Only apply to authenticated users
    if (!$user) {
        return $next($request);
    }
 
    // Don't redirect if already on the profile completion page or its POST route
    // to prevent an infinite redirect loop
    if ($request->routeIs('verification.notice') || $request->routeIs('verification.verify')) {
        return $next($request);
    }
 
    // Check if required fields are missing or set to NULL
    if ($user->email_verified_at === null ) {
        return redirect()->route('verification.notice');
    }
 
    return $next($request);
}
}
