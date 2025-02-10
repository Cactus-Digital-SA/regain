<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($request->is('organization') || $request->is('organization/*')) {
                    return redirect()->route('organization.login');
                }

                if ($request->is('practitioner') || $request->is('practitioner/*')) {
                    return redirect()->route('practitioner.login');
                }

                return redirect(route("patient.success"));
            }
        }

        return $next($request);
    }
}
