<?php

namespace App\Domains\Organisation\Http\Controllers;

use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Repositories\Eloquent\Models\Role;
use App\Domains\Auth\Repositories\Eloquent\Models\User as EloquentUser;
use App\Domains\Auth\Services\UserService;
use App\Domains\Patient\Enums\StatusEnum;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Patient\Services\PatientDataService;
use App\Domains\PatientAssignments\Services\PatientAssignmentService;
use App\Domains\Practitioner\Services\PractitionersService;
use App\Domains\Organisation\Http\Requests\StorePatientRequest;
use App\Domains\Region\Services\RegionService;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Mail\RegainEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Nette\NotImplementedException;
use Throwable;

class PatientController extends Controller
{
    public function __construct(
        private readonly PatientDataService $patientDataService,
        private readonly UserService $userService,
        private readonly PractitionersService $practitionersService,
        private readonly RegionService $regionService,
        private readonly PatientAssignmentService $patientAssignmentService,
    ) {

    }

    /**
     * @throws \JsonException
     */
    public function patients()
    {
        $columns     = $this->patientDataService->getTableColumns();
        $regions     = $this->regionService->get();
        $regionsJson = json_encode(array_map(function ($region) {
            return ['id' => $region->getId(), 'name' => $region->getName()];
        }, $regions), JSON_THROW_ON_ERROR);

        return view('organisation.patients', compact('columns', 'regions', 'regionsJson'));
    }

    public function practitioners()
    {
        $columns     = $this->practitionersService->getTableColumns();
        $regions     = $this->regionService->get();
        $regionsJson = json_encode(array_map(function ($region) {
            return ['id' => $region->getId(), 'name' => $region->getName()];
        }, $regions), JSON_THROW_ON_ERROR);

        $allocatedPatients = $this->patientAssignmentService->getAllocatedPatients();

        $capacity = (int)(((71 + count($allocatedPatients)) / 273) * 100);

        return view('organisation.practitioners', compact('columns', 'regions', 'regionsJson', 'capacity'));
    }

    public function emailExists(Request $request): JsonResponse
    {
        $email = $request->input('email');

        return response()->json(
            ["exists" => $this->patientDataService->emailExists($email)]
        );
    }

    public function storePatient(StorePatientRequest $request): JsonResponse
    {
        $password = Str::random(8); // random 8 char password

        $userModel = (new User())
            ->setName($request->getName())
            ->setActive(true)
            ->setEmail($request->getEmail())
            ->setPassword($password);

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
                    ->setStatus(StatusEnum::INACTIVE)
                    ->setIsMilitary($request->isMilitary())
                    ->setNotes($request->getNotes());

                if ($model->isMilitary()) {
                    $model->setMilitaryStatus($request->getMilitaryStatus());
                }

                $this->patientDataService->store($model);

                $userName = $user?->getEmail();
                try {
                    Mail::to($user->getEmail())->send(new RegainEmail($userName, $password));
                } catch (Throwable $e) {
                    Log::error($e->getMessage());
                }
            }
        } catch (Throwable $e) {
            // cleanup delete the user so they can try again
            $this->userService->destroy($user->getId());

            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }

        return response()->json([
            "success" => true
        ]);
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

    public function getPatientInfo(int $id): JsonResponse
    {
        $patientInfo = $this->patientDataService->getByUserId($id);

        $data                   = $patientInfo->getValues();
        $data['email']          = $patientInfo->getUser()->getEmail();
        $data['fullName']       = $patientInfo->getUser()->getName();
        $data['regionName']     = $patientInfo->getRegion()->getName();
        $data['militaryStatus'] = $patientInfo->getMilitaryStatus()?->label() ?? "";

        return response()->json($data);
    }
}
