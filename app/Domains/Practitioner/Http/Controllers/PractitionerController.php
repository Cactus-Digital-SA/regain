<?php

declare(strict_types = 1);

namespace App\Domains\Practitioner\Http\Controllers;

use App\Domains\Patient\Services\PatientDataService;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\UserResponse\Http\Requests\SubmitUserResponsesRequest;
use App\Domains\UserResponse\Services\UserResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PractitionerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly QuestionsService $questionsService,
        private readonly UserResponseService $responseService,
        private readonly PatientDataService $patientDataService
    ) {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        // $presenter = $this->questionsService->fetchQuestionsAlt(Auth::id(), 10);
        $patients = $this->patientDataService->getTableColumns();

        return view('practitioner.index')->with('columns', $patients);
    }
}
