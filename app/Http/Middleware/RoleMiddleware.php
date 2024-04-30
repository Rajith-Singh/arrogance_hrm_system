<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect to login page if the user is not authenticated
            return redirect('/login');
        }

        // If the user is authenticated but roles are provided, check for roles
        if ($roles && !in_array(Auth::user()->usertype, $roles)) {
            // If user does not have the required role, redirect to the login page with error
            return redirect('/login')->with('error', 'Unauthorized access - Insufficient permissions');
        }

        // Allow the request to proceed if no role check is needed or if role check passes
        return $next($request);
    }
}



