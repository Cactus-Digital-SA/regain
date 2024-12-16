<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class RedirectMiddleware
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
            if (auth()->user()->isAdmin()) {
                if (!$request->routeIs('admin.*')) {
                    return redirect()->route('admin.home');
                }

                return $next($request);
            }

            if (auth()->user()->isPatient()) {
                if (!$request->routeIs('patient.*')) {
                    return redirect()->route('patient.home');
                }

                return $next($request); // Proceed to the next middleware or controller
            }

            if (auth()->user()->isRegainUser()) {
                if (!$request->routeIs('organization.*')) {
                    return redirect()->route('organization.home');
                }

                return $next($request);
            }

            if (auth()->user()->isPractitioner()) {
                if (!$request->routeIs('practitioner.*')) {
                    return redirect()->route('practitioner.home');
                }

                return $next($request);
            }
        }

        throw new UnauthorizedException("Unauthorized");
    }
}
