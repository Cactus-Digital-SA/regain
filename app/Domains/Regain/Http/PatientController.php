<?php

namespace App\Domains\Regain\Http;

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

    public function create()
    {
        return view('backend.content.prospect.create');
    }

    public function show(string $prospectId)
    {
        $prospect = $this->prospectService->getByIdWithMorphsAndRelations($prospectId);

        return view('backend.content.prospect.show', compact('prospect'));
    }

    public function store(Request $request)
    {
        $userDTO = new User();
        $userDTO->setName($request['name']);
        $userDTO->setEmail($request['email']);
        $userDTO->setPassword('123456');  // todo demo pass
        $user = $this->userService->store($userDTO);

        $request['user_id'] = $user->getId();

        $patientDTO = PatientData::fromRequest($request);
        $this->patientDataService->store($patientDTO);

        return redirect()->route('prospect.index')->with('success', 'Το Prospect δημιουργήθηκε επιτυχώς');
    }

    public function update(Request $request, string $prospectId)
    {

    }

    public function destroy(string $prospectId)
    {

    }

    public function datatable(Request $request)
    {
        $filters = Helpers::filters($request);
        return $this->patientDataService->dataTable($filters);
    }

}
