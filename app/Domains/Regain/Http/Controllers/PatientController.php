<?php

namespace App\Domains\Regain\Http\Controllers;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Patient\Services\PatientDataService;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(private PatientDataService $patientDataService, private UserService $userService)
    {

    }
    public function index()
    {
        $columns = $this->patientDataService->getTableColumns();

        return view('regain.patients.index', compact('columns'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $userDTO = new User();
        $userDTO->setName($request['name']);
        $userDTO->setEmail($request['email']);
        $userDTO->setPassword('123456');  // todo demo pass
        $user = $this->userService->store($userDTO);

        $request['user_id'] = $user->getId();

        $patientDTO = PatientData::fromRequest($request);
        $this->patientDataService->store($patientDTO);

        return redirect()->route('regain.patients.index')->with('success', 'Patient created successfully');
    }

    public function update(Request $request, string $patient)
    {

    }

    public function destroy(string $patient): \Illuminate\Http\RedirectResponse
    {
        $response = $this->patientDataService->deleteById($patient);
        if($response){
            return redirect()->back()->with('success', 'Patient deleted successfully');
        }

        return redirect()->back()->with('error', 'There was a problem deleting the patient.');
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        $filters = Helpers::filters($request);
        return $this->patientDataService->dataTable($filters);
    }

}
