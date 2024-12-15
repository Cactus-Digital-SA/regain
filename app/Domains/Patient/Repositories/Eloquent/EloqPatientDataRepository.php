<?php

namespace App\Domains\Patient\Repositories\Eloquent;

use App\Domains\Auth\Repositories\Eloquent\Models\User;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Patient\Repositories\Eloquent\Models\PatientData as EloqPatientData;
use App\Domains\Patient\Repositories\PatientDataRepositoryInterface;
use App\Domains\PatientAssignments\Services\PatientAssignmentService;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use Yajra\DataTables\DataTables;

class EloqPatientDataRepository implements PatientDataRepositoryInterface
{
    public function __construct(
        protected readonly Models\PatientData $model,
        protected readonly PatientAssignmentService $patientAssignmentService
    ) {
    }

    public function get(): ?array
    {
        $patientData = $this->model::all()->load('user');

        return ObjectSerializer::deserialize($patientData?->toJson() ?? "{}", "array<" . PatientData::class . ">", 'json');
    }

    public function getById(string $id): ?PatientData
    {
        $patientData = $this->model::find($id);

        $patientData->load('user');

        return ObjectSerializer::deserialize($patientData?->toJson() ?? "{}", PatientData::class, 'json');
    }

    public function getByUserId(string $userId): ?PatientData
    {
        $patientData = $this->model::where('user_id', $userId)->with("user")->first();
        if ($patientData) {
            return ObjectSerializer::deserialize($patientData?->toJson() ?? "{}", PatientData::class, 'json');
        }

        return null;
    }

    public function store(CactusEntity|PatientData $entity): ?PatientData
    {
        $patientData = $this->model::create([
            'user_id'             => $entity->getUserId(),
            'birthday'            => $entity->getBirthday(),
            'region_id'           => $entity->getRegionId(),
            'post_code'           => $entity->getPostCode(),
            'primary_phone'       => $entity->getPrimaryPhone(),
            'secondary_phone'     => $entity->getSecondaryPhone(),
            'accessible_mobility' => $entity->getAccessibleMobility(),
            'notes'               => $entity->getNotes(),
        ]);

        return ObjectSerializer::deserialize($patientData?->toJson() ?? "{}", PatientData::class, 'json');
    }

    public function updateByUserId(CactusEntity|PatientData $entity, string $userId): ?PatientData
    {
        $patientData = $this->model->where('user_id', $userId)->firstOrFail();

        $patientData->update([
            'birthday'            => $entity->getBirthday(),
            'region_id'           => $entity->getRegionId(),
            'post_code'           => $entity->getPostCode(),
            'primary_phone'       => $entity->getPrimaryPhone(),
            'secondary_phone'     => $entity->getSecondaryPhone(),
            'accessible_mobility' => $entity->getAccessibleMobility(),
            'notes'               => $entity->getNotes(),
        ]);

        return ObjectSerializer::deserialize($patientData->toJson() ?? "{}", PatientData::class, 'json');
    }

    public function update(CactusEntity|PatientData $entity, string $id): ?PatientData
    {

    }

    public function deleteById(string $id): bool
    {
        $patientData = $this->model->findOrFail($id);
        $patientData->user->delete();

        return $patientData->delete();
    }

    /**
     * @inheritDoc
     */
    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        $user = User::find($userId);

        $patientData = null;
        if ($user->isPractitioner()) {
            // get assigned patients
            $availablePatientIds = array_map(static function ($patient) {
                return $patient->getPatientUserId();
            }, $this->patientAssignmentService->getByPractitionerUserId($user->id));
            $patientData         = EloqPatientData::whereIn("user_id", $availablePatientIds)->with("user")->select('patient_data.*');
        } elseif ($user->isRegainUser()) {
            $patientData = $this->model->with('user')->select('patient_data.*');
        } else {
            throw new UnauthorizedException();
        }

        return DataTables::of($patientData)
                         ->editColumn('id', function ($data) {
                             return '#OP' . $data->id;
                         })
                         ->editColumn('name', function ($data) use ($user) {
                             if (!$user) {
                                 return e($data->user->name);
                             }

                             if ($user->isPractitioner()) {
                                 $url = route('practitioner.patient', ['userId' => $data->user->id]);

                                 return '<a href="' . $url . '">' . e($data->user->name) . '</a>';
                             }

                             return e($data->user->name);
                         })
                         ->editColumn('registered', function ($data) {
                             return $data?->user?->created_at?->format('d-m-Y') ?? ' - ';
                         })
                         ->editColumn('status', function ($data) {
                             return $data?->status?->value ?? ' - ';
                         })
                         ->addColumn('actions', function ($data) use ($user) {
                             $deleteUrl = route('regain.patients.destroy', [
                                 'patient' => $data->id,
                             ]);

                             if (!$user) {
                                 return '<div class="btn-group">-</div>';
                             }

                             $html = '<div class="btn-group">';

//                $html .= '<a href="' . route('regain.patients.edit', $data->id) . '" class="btn btn-icon btn-gradient-warning">
//                             <i class="ti ti-edit ti-xs"></i>
//                        </a>';
//
                             if ($user->isRegainUser()) {
                                 $html .= '<a href="#" class="btn btn-icon btn-gradient-danger"
                           data-bs-toggle="modal" data-bs-target="#deleteModal"
                           onclick="deleteForm(\'' . $deleteUrl . '\')">
                            <i class="ti ti-trash ti-xs"></i>
                       </a>';
                             }

                             $html .= '</div>';

                             return $html;
                         })
                         ->makeHidden(['created_at', 'updated_at', 'deleted_at'])
                         ->rawColumns(['actions', 'name'])
                         ->toJson();
    }

    /**
     * @inheritDoc
     */
    public function getTableColumns(): array
    {
        return [
            'id' => ['name' => 'id', 'table' => 'patient_data.id', 'searchable' => 'false', 'sortable' => 'true'],

            'name'       => ['name' => 'Patient Name', 'table' => 'users.name', 'searchable' => 'false', 'sortable' => 'false'],
            'registered' => ['name' => 'Registered', 'table' => 'users.created_at', 'searchable' => 'false', 'sortable' => 'false'],
//            'region' => ['name' => 'Region', 'table' => 'region.name', 'searchable' => 'false', 'sortable' => 'false'],

            'status' => ['name' => 'Status', 'table' => 'status', 'searchable' => 'false', 'sortable' => 'false'],

        ];
    }
}
