<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Domains\Auth\Services\UserService;
use Illuminate\Support\Facades\App;

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

                return redirect('/home');
            }
        }


        if($request->is('login') || $request->is('login/*')) {
            if ($request->query('register') == true) {

                $userService = App::make(UserService::class);
                $user = $userService->getByEmail($request->input('email'));
                $roles = $user->getRoles();

                $isPatient = false;
                foreach ($roles as $role) {
                    if ($role->getName() == 'Patient') {
                        $isPatient = true;
                    }
                }

                if ($user && $isPatient) {
                    Auth::loginUsingId($user->getId());
                    return redirect()->route('register.success');
                }
                dd(2);
            }
        }

        return $next($request);
    }
}
