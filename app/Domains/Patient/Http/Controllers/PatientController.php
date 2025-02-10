<?php

declare(strict_types = 1);

namespace App\Domains\Patient\Http\Controllers;

use App\Domains\Questions\Services\QuestionsService;
use App\Domains\UserResponse\Http\Requests\SubmitUserResponseRequest;
use App\Domains\UserResponse\Http\Requests\SubmitUserResponsesRequest;
use App\Domains\UserResponse\Services\UserResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function ask(): View
    {
        $presenter = $this->questionsService->fetchQuestionsAlt(Auth::id(), 10);

        $questions = $presenter->getQuestions();
        if (count($questions) > 0 && $questions[0]->getId() >= 41) {
            return view('patient.ask-alt')->with(
                ["presenter" => $presenter]
            );
        }

        return view('patient.ask')->with(
            ["presenter" => $presenter]
        );
    }

    public function registerFlow(): View
    {
        return view('patient.flow.register.index');
    }

    public function registerSuccess(): View
    {
        return view('patient.flow.register.success');
    }

    public function handleLandingPageFlow(Request $request): View
    {
        $referer = request()->headers->get('referer');
        $refererPath = $referer ? parse_url($referer, PHP_URL_PATH) : null;

        if ($refererPath === "/register") {
            return view('patient.flow.register.success');
        }

        if ($request->get("register")) {
            return view('patient.home', ["back" => false]);
        }

        return view('patient.home', ["back" => true]);
    }

    public function submitAnswers(SubmitUserResponsesRequest $request): JsonResponse
    {
        $submittedData = $request->getSubmittedUserResponseForms();
        $submitted     = $this->responseService->submitAnswers($submittedData);

        if ($submitted) {
            return response()->json([
                'success' => true,
                'message' => 'Answers submitted successfully.'// Send the questions as part of the response
            ], 200); // 200 OK status
        }

        Log::error('Could not submit answer for user ' . $submittedData->getUserId(), [
            'questionIs' => $submittedData,
        ]);

        abort(500);
    }
}
