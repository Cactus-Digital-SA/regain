<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $route = null;
        if (auth()->user()->isAdmin()) {
            $route = route('admin.tests.questions.index');
        } elseif (auth()->user()->isRegainUser()) {
            $route = route('regain.patients.create');
        } elseif (auth()->user()->isPractitioner()) {
            $route = route('pratitioners.index');
        } elseif (auth()->user()->isPatient()) {
            $route = route('patient.home');
        }

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect($route);
    }
}