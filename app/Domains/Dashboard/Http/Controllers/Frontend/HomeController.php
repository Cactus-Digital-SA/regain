<?php

namespace App\Domains\Dashboard\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController.
 */
class HomeController
{
    public function index()
    {
        //return view('welcome');
        //Todo Remove this to have different from end
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        return redirect('admin.home');
    }
}
