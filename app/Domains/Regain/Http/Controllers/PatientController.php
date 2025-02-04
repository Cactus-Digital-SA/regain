<?php

namespace App\Domains\Regain\Http\Controllers;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Repositories\Eloquent\Models\User as EloquentUser;
use App\Domains\Auth\Repositories\Eloquent\Models\Role;
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
use Illuminate\View\View;
use Nette\NotImplementedException;
use Throwable;

class PatientController extends Controller
{
    public function __construct(
        private readonly PatientDataService $patientDataService,
        private readonly UserService $userService,
        private readonly PractitionersService $practitionersService,
        private readonly RegionService $regionService,
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
        $regions = $this->regionService->get();

        return view('organization.practitioners', compact('columns', 'regions'));
    }

    public function createPatientPage(Request $request, int $page): View
    {
        $regions = $this->regionService->get();

        return match ($page) {
            1 => view('organization.includes.create-patient-first')->with('regions', $regions),
            2 => view('organization.includes.create-patient-second'),
        };
    }

    public function storePatient(StorePatientRequest $request): View
    {
        // $password rand password keep it for the email
        $userModel = (new User())
            ->setName($request->getName())
            ->setActive(true)
            ->setEmail($request->getEmail())
            ->setPassword('123456'); // $password

        try {
            $user        = $this->userService->store($userModel);
            $patientRole = Role::findById(RolesEnum::Patient->value);
            EloquentUser::find($user->getId())->assignRole($patientRole);

            if ($user->getId() !== null) {
                $model = (new PatientData())
                    ->setUserId($user->getId())
                    ->setRegionId($request->getRegion())
                    ->setBirthday($request->getBirthday())
                    ->setPostCode($request->getPostCode())
                    ->setPrimaryPhone($request->getPhone())
                    ->setSecondaryPhone($request->getSecondaryPhone())
                    ->setAccessibleMobility($request->getMobility())
                    ->setNotes($request->getNotes());

                $this->patientDataService->store($model);

                // set the email, notifications domain, use the password here.

                return view("organization.includes.patient-stored");
            }
        } catch (Throwable $e) {
            return view('organization.includes.create-patient-first')->with('regions', $this->regionService->get());
        }

        return view('organization.includes.create-patient-first')->with('regions', $this->regionService->get());
    }

    public function update(Request $request, string $patient): void
    {
        throw new NotImplementedException();
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
