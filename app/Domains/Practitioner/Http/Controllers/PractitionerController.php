<?php

declare(strict_types = 1);

namespace App\Domains\Practitioner\Http\Controllers;

use App\Domains\Patient\Services\PatientDataService;
use App\Domains\PatientAssignments\Services\PatientAssignmentService;
use App\Domains\Practitioner\Services\PractitionersService;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\Reports\Http\Services\ReportService;
use App\Domains\UserResponse\Http\Requests\SubmitMedicalHistoryResponsesRequest;
use App\Domains\UserResponse\Services\UserResponseService;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PractitionerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly PractitionersService $practitionerService,
        private readonly QuestionsService $questionsService,
        private readonly PatientDataService $patientDataService,
        private readonly UserResponseService $responseService,
        private readonly PatientAssignmentService $patientAssignmentService,
        private readonly ReportService $reportService,
    ) {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $practitioner = $this->practitionerService->getByUserId((string)Auth::id());

        return view('practitioner.home')
            ->with('columns', [])
            ->with('practitioner', $practitioner);
    }

    public function patients(): View
    {
        $practitioner = $this->practitionerService->getByUserId((string)Auth::id());
        $patientData  = $this->patientDataService->get();

        return view('practitioner.patients')
            ->with('patientData', $patientData)
            ->with('columns', $this->patientDataService->getTableColumns())
            ->with('practitioner', $practitioner);
    }

    public function patient(Request $request, int $userId)
    {
        $assignedPatients    = $this->patientAssignmentService->getByPractitionerUserId((string)Auth::id());
        $practitionerUserIds = array_map(static fn ($user) => $user->getPatientUserId(), $assignedPatients);

        // Check if $userId is in the list of practitioner user IDs
        if (!in_array($userId, $practitionerUserIds, true)) {
            throw new AuthorizationException("User ID $userId is not authorized to access this report.");
        }

        $practitioner = $this->practitionerService->getByUserId((string)Auth::id());
        $patientData  = $this->patientDataService->getByUserId((string)$userId);
        if ($patientData === null) {
            return redirect()->route('practitioner.patients');
        }

        $presenter = $this->reportService->getFlowPresenterForUser($userId);

        return view('practitioner.patient')
            ->with('columns', [])
            ->with('practitioner', $practitioner)
            ->with('patientData', $patientData)
            ->with('presenter', $presenter);
    }

    public function getMedicalHistoryQuestions(Request $request, int $forUserId)
    {
        $assignedPatients    = $this->patientAssignmentService->getByPractitionerUserId((string)Auth::id());
        $practitionerUserIds = array_map(static fn ($user) => $user->getPatientUserId(), $assignedPatients);

        // Check if $userId is in the list of practitioner user IDs
        if (!in_array($forUserId, $practitionerUserIds, true)) {
            throw new AuthorizationException("User ID $forUserId is not authorized to access this report.");
        }

        $presenter = $this->questionsService->fetchMedicalHistoryQuestions(Auth::id(), $forUserId);

        return $presenter->isCompleted() ?
            view('practitioner.medical-history-completed')->with('presenter', $presenter) :
            view('practitioner.medical-history-questions')->with('presenter', $presenter);
    }

    public function submitMedicalHistoryQuestions(SubmitMedicalHistoryResponsesRequest $request): View
    {
        $submittedData = $request->getSubmittedMedicalHistoryResponseForm();
        $submitted     = $this->responseService->submitAnswers($submittedData);

        if ($submitted) {
            $presenter = $this->questionsService->fetchMedicalHistoryQuestions(Auth::id(), $submittedData->getForUserId());

            return $presenter->isCompleted() ?
                view('practitioner.medical-history-completed')->with('presenter', $presenter) :
                view('practitioner.medical-history-questions')->with('presenter', $presenter);
        }

        Log::error('Could not submit answer for user ' . $submittedData->getUserId(), [
            'questionIs' => $submittedData,
        ]);

        abort(500);
    }

    public function datatable(Request $request)
    {
        $filters = Helpers::filters($request);

        return $this->patientDataService->dataTable(Auth::id(), $filters);
    }
}
