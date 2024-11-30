<?php

namespace App\Domains\Patient\Http\Controllers;

use App\Domains\Questions\Services\QuestionsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PatientController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly QuestionsService $service,
    ) {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $question = $this->service->getActiveQuestion(Auth::user()->id);

        return view('patient.index')->with(
            ["question" => $question]
        );
    }

    public function store(): RedirectResponse
    {
        $question = $this->service->getActiveQuestion(Auth::user()->id);

        return redirect(Route("patient.home"))->with(
            ["question" => $question]
        );
    }
}
