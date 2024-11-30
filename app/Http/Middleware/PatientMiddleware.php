<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        if (auth()->check() && auth()->user()->isPatient()) {
            return $next($request); // Proceed to the next middleware or controller
        }
    }
}
