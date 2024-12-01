<?php

namespace App\Domains\MockFront\Http\Controllers;

use App\Http\Controllers\Controller;

class MockFrontController extends  Controller
{

    public function showDateOfBirth()
    {
        return view('frontend.content.mock.date-of-birth');
    }

}
