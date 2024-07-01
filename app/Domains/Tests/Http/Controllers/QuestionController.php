<?php

namespace App\Domains\Tests\Http\Controllers;

use App\Domains\Tests\Services\QuestionsService;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class QuestionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected QuestionsService $questionsService,
    ) {}

    /**
     * @return View
     */
    public function index() : View
    {
        return view('backend.content.questions.index');
    }
}
