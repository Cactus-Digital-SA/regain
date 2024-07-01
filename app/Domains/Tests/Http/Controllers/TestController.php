<?php

namespace App\Domains\Tests\Http\Controllers;

use App\Domains\Tests\Services\TestService;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TestController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct(
        private TestService $testService,
    ) {}


    /**
     * @return View
     */
    public function index() : View
    {
        return view('backend.content.tests.index');
    }
}
