<?php

namespace App\Domains\Regain\Http\Controllers;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Patient\Services\PatientDataService;
use App\Domains\Practitioner\Services\PractitionersService;
use App\Domains\Regain\Http\Requests\StorePatientRequest;
use App\Domains\Region\Services\RegionService;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function __construct(
        private PatientDataService $patientDataService,
        private UserService $userService,
        private PractitionersService $practitionersService,
        private RegionService $regionService,
    ) {

    }

    public function patients()
    {
        $columns = $this->patientDataService->getTableColumns();
        $regions = $this->regionService->get();

        return view('organization.patients', compact('columns', 'regions'));
    }

    public function practitioners()
    {
        $columns = $this->practitionersService->getTableColumns();

        return view('organization.practitioners', compact('columns'));
    }

    public function createPatientPage(Request $request, int $page): View
    {
        $regions = $this->regionService->get();

        return match ($page) {
            1 => view('organization.includes.create-patient-first')->with('regions', $regions),
            2 => view('organization.includes.create-patient-second'),
        };
    }

    public function storePatient(Request $request): RedirectResponse
    {
        //bill made custom request, uncomment region (StorePatientRequest)?
        $userDTO = new User();
        $userDTO->setName($request['name']);
        $userDTO->setEmail($request['email']);
        $userDTO->setPassword('123456');  // todo demo pass
        $user = $this->userService->store($userDTO);

        $request['user_id'] = $user->getId();

        $patientDTO = PatientData::fromRequest($request);
        $this->patientDataService->store($patientDTO);

        return redirect()->route('organization.index')->with('success', 'Patient created successfully');
    }

    public function update(Request $request, string $patient)
    {

    }

    public function patientsDestroy(string $patient): RedirectResponse
    {
        $response = $this->patientDataService->deleteById($patient);
        if ($response) {
            return redirect()->back()->with('success', 'Patient deleted successfully');
        }

        return redirect()->back()->with('error', 'There was a problem deleting the patient.');
    }

    public function patientsDatatable(Request $request): JsonResponse
    {
        $filters = Helpers::filters($request);

        return $this->patientDataService->dataTable(Auth::id(), $filters);
    }

    public function practitionersDatatable(Request $request): JsonResponse
    {
        $filters = Helpers::filters($request);

        return $this->practitionersService->dataTable(Auth::id(), $filters);
    }
}
