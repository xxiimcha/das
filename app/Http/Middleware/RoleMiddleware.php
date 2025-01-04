<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check if the user has the required role
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
