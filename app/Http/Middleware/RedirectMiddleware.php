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
                return redirect()->route('admin.home');
            }

            if (auth()->user()->isPatient()) {
                return $next($request); // Proceed to the next middleware or controller
            }

            if (auth()->user()->isRegainUser()) {
                return redirect()->route('regain.user.home');
            }
        }

        throw new UnauthorizedException("Unauthorized");
    }
}
