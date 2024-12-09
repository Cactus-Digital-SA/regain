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
        $questions = $this->questionsService->fetchQuestionsAlt(Auth::id(), 10);

        return view('patient.index')->with(
            ["questions" => $questions]
        );
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
