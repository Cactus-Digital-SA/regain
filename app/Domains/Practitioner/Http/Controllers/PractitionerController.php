<?php

declare(strict_types = 1);

namespace App\Domains\Practitioner\Http\Controllers;

use App\Domains\Patient\Services\PatientDataService;
use App\Domains\Practitioner\Services\PractitionersService;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\UserResponse\Http\Requests\SubmitUserResponsesRequest;
use App\Domains\UserResponse\Services\UserResponseService;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
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
        $practitioner = $this->practitionerService->getByUserId((string)Auth::id());
        $patientData  = $this->patientDataService->getByUserId((string)$userId);
        if ($patientData === null) {
            return redirect()->route('practitioner.patients');
        }

        return view('practitioner.patient')
            ->with('columns', [])
            ->with('practitioner', $practitioner)
            ->with('patientData', $patientData);
    }

    public function getMedicalHistoryQuestions(Request $request, int $forUserId)
    {
        $presenter = $this->questionsService->fetchMedicalHistoryQuestions(Auth::id(), $forUserId);

        return view('patient.index')->with('presenter', $presenter);
    }

    public function datatable(Request $request)
    {
        $filters = Helpers::filters($request);

        return $this->patientDataService->dataTable(Auth::id(), $filters);
    }
}
