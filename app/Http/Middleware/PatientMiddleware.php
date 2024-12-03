<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class PatientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the logged-in user has the 'patient' role
        if (auth()->check()) {
            if (auth()->user()->isPatient()) {
                return $next($request); // Proceed to the next middleware or controller
            } elseif (auth()->user()->isAdmin()) {
                return redirect()->route('admin.home');
            }
        }

        throw new UnauthorizedException("Unauthorized");
    }
}
