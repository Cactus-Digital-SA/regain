<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $route = auth()->user()->isAdmin() ? route('admin.tests.questions.index') : route('patient.home');

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect($route);
    }
}