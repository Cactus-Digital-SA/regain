<?php

declare(strict_types = 1);

namespace App\Domains\Practitioner\Http\Controllers;

use App\Domains\Patient\Services\PatientDataService;
use App\Domains\PatientAssignments\Services\PatientAssignmentService;
use App\Domains\Practitioner\Services\PractitionersService;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\Reports\Http\Services\ReportService;
use App\Domains\Reports\Repositories\Eloquent\Models\ReportFile;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use App\Domains\UserQuestionnaire\Services\UserQuestionnaireService;
use App\Domains\UserResponse\Http\Requests\SubmitMedicalHistoryResponsesRequest;
use App\Domains\UserResponse\Services\UserResponseService;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        private readonly UserQuestionnaireService $userQuestionnaireService
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
            ->with('columns', $this->patientDataService->getTableColumnsNoRegion())
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

        $medicalHistoryCompleted               = $this->userQuestionnaireService->getMedicalHistoryCompletedAtForUser(Auth::id(), $userId);
        $medicalHistoryPresenter               = [];
        $medicalHistoryPresenter['details']    = [];
        $medicalHistoryPresenter['medication'] = [];

        if ($medicalHistoryCompleted !== null) {
            $medicalHistoryResult = $this->questionsService->getMedicalHistoryReportForPatient(Auth::id(), $userId);

            if ($patientData->getAccessibleMobility()) {
                $medicalHistoryPresenter['details'][] = "Accessible Mobility";
            }

            foreach ($medicalHistoryResult->getQuestionAnswers() as $answer) {
                if (str_contains($answer->getQuestionText(), "penicillin")) {
                    if ($answer->getAnswerText() === "Yes") {
                        $medicalHistoryPresenter['details'][] = "Penicillin";
                    }
                }

                if (str_contains($answer->getQuestionText(), "HIV")) {
                    if ($answer->getAnswerText() === "Yes") {
                        $medicalHistoryPresenter['details'][] = "HIV";
                    }
                }

                if (str_contains($answer->getQuestionText(), "anaphylaxis")) {
                    if ($answer->getAnswerText() === "Yes") {
                        $medicalHistoryPresenter['details'][] = "anaphylaxis";
                    }
                }

                if ("What is the name of the OTC medication?" === $answer->getQuestionText()) {
                    $medicalHistoryPresenter['medication'] = explode(" ", $answer->getAnswerText());
                }
            }

            if (empty($medicalHistoryPresenter['details'])) {
                $medicalHistoryPresenter['details'] = ["-"];
            }
        }

        if ($patientData === null) {
            return redirect()->route('practitioner.patients');
        }

        $presenter               = $this->reportService->getFlowPresenterForUser($userId);
        $medicalHistoryCompleted = $this->userQuestionnaireService->getMedicalHistoryCompletedAtForUser(Auth::id(), $userId);
        $medicalHistoryResult    = ($medicalHistoryCompleted !== null) ?
            $this->questionsService->getMedicalHistoryReportForPatient(Auth::id(), $userId) :
            null;

        return view('practitioner.patient')
            ->with('columns', [])
            ->with('practitioner', $practitioner)
            ->with('patientData', $patientData)
            ->with('medicalHistoryCompleted', $medicalHistoryCompleted)
            ->with('medicalHistoryResult', $medicalHistoryResult)
            ->with('medicalHistoryPresenter', $medicalHistoryPresenter)
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
            view('practitioner.includes.medical-history-completed')->with('presenter', $presenter) :
            view('practitioner.includes.medical-history-questions')->with('presenter', $presenter);
    }

    public function submitMedicalHistoryQuestions(SubmitMedicalHistoryResponsesRequest $request): View
    {
        $submittedData = $request->getSubmittedMedicalHistoryResponseForm();
        $submitted     = $this->responseService->submitAnswers($submittedData);

        if ($submitted) {
            $presenter = $this->questionsService->fetchMedicalHistoryQuestions(Auth::id(), $submittedData->getForUserId());

            return $presenter->isCompleted() ?
                view('practitioner.includes.medical-history-completed')->with('presenter', $presenter) :
                view('practitioner.includes.medical-history-questions')->with('presenter', $presenter);
        }

        Log::error('Could not submit answer for user ' . $submittedData->getUserId(), [
            'questionIs' => $submittedData,
        ]);

        abort(500);
    }

    public function getMedicalHistoryReport(int $userId): View
    {
        $result = $this->questionsService->getMedicalHistoryReportForPatient(Auth::id(), $userId);

        return view("reports.medicalHistory.index")->with(
            [
                'result' => $result
            ]);
    }

    public function downloadMedicalHistoryReport(int $userId): BinaryFileResponse
    {
        $testId = Test::whereIn('category_id', static function ($query) {
            $query->select("category_id")
                  ->from("questionnaire_flows")
                  ->where('flow_type', QuestionnaireFlowType::MEDICAL_HISTORY->value);
        })->pluck("id")->first();

        $filePath = $this->reportService->getFilePath(Auth::id(), $userId, $testId);
        if (($filePath !== null) && Storage::exists($filePath)) {
            return response()->file(storage_path("app/$filePath"), [
                'Content-Type' => 'application/pdf',
            ]);
        }

        $result = $this->questionsService->getMedicalHistoryReportForPatient(Auth::id(), $userId);

        $uuid = Uuid::uuid4()->toString();

        ReportFile::create([
            "practitioner_user_id" => Auth::id(),
            "patient_user_id"      => $result->getPatientData()->getUserId(),
            "test_id"              => $testId,
            "uuid"                 => $uuid,
        ]);

        $filePath = "reports/{$uuid}.pdf";

        $pdf = PDF::loadView('reports.medicalHistory.pdf', ['result' => $result]);

        Storage::put($filePath, $pdf->output());

        return response()->download(storage_path("app/$filePath"), [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function datatable(Request $request)
    {
        $filters = Helpers::filters($request);

        return $this->patientDataService->dataTable(Auth::id(), $filters);
    }
}
