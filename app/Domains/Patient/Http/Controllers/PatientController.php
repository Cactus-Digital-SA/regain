<?php

declare(strict_types = 1);

namespace App\Domains\Patient\Http\Controllers;

use App\Domains\Questions\Services\QuestionsService;
use App\Domains\UserResponse\Http\Requests\SubmitUserResponseRequest;
use App\Domains\UserResponse\Services\UserResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PatientController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly QuestionsService $questionsService,
        private readonly UserResponseService $responseService,
    ) {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $question = $this->questionsService->getActiveQuestion(Auth::id());

        return view('patient.index')->with(
            ["question" => $question]
        );
    }

    public function submitAnswer(SubmitUserResponseRequest $request): RedirectResponse
    {
        $submittedData = $request->getSubmittedUserResponseForm();
        $submitted     = $this->responseService->submitAnswer($submittedData);

        if ($submitted) {
            $activeQuestion = $this->questionsService->getActiveQuestion($submittedData->getUserId());

            return redirect(Route("patient.home"))->with(
                ["question" => $activeQuestion]
            );
        }

        Log::error('Could not submit answer for user ' . $submittedData->getUserId(), [
            'questionId' => $submittedData->getQuestionId(),
        ]);

        abort(500);
    }
}
