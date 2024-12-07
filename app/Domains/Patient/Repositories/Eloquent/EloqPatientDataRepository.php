<?php

namespace App\Domains\Patient\Repositories\Eloquent;

use App\Domains\Patient\Models\PatientData;
use App\Domains\Patient\Repositories\PatientDataRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class EloqPatientDataRepository implements PatientDataRepositoryInterface
{
    public function __construct(protected readonly Models\PatientData $model)
    {
    }

    public function get(): ?array
    {
        $patientData = $this->model::all();
        return ObjectSerializer::deserialize($patientData?->toJson() ?? "{}",  "array<". PatientData::class . ">" , 'json');
    }

    public function getById(string $id): ?PatientData
    {
        $patientData = $this->model::find($id);

        $patientData->load('user');

        return ObjectSerializer::deserialize($patientData?->toJson() ?? "{}",  PatientData::class , 'json');
    }

    public function store(CactusEntity|PatientData $entity): ?PatientData
    {
        $patientData = $this->model::create([
            'user_id' => $entity->getUserId(),
            'birthday' => $entity->getBirthday(),
            'region_id' => $entity->getRegionId(),
            'post_code' => $entity->getPostCode(),
            'primary_phone' => $entity->getPrimaryPhone(),
            'secondary_phone' => $entity->getSecondaryPhone(),
            'accessible_mobility' => $entity->getAccessibleMobility(),
            'notes' => $entity->getNotes(),
        ]);


        return ObjectSerializer::deserialize($patientData?->toJson() ?? "{}",  PatientData::class , 'json');
    }

    public function update(CactusEntity|PatientData $entity, string $id): ?PatientData
    {

    }

    public function updateByUserId(CactusEntity|PatientData $entity, string $userId): ?PatientData
    {
        $patientData = $this->model->where('user_id',$userId)->firstOrFail();

        $patientData->update([
            'birthday' => $entity->getBirthday(),
            'region_id' => $entity->getRegionId(),
            'post_code' => $entity->getPostCode(),
            'primary_phone' => $entity->getPrimaryPhone(),
            'secondary_phone' => $entity->getSecondaryPhone(),
            'accessible_mobility' => $entity->getAccessibleMobility(),
            'notes' => $entity->getNotes(),
        ]);


        return ObjectSerializer::deserialize($patientData->toJson() ?? "{}", PatientData::class, 'json');
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
    }

    /**
     * @inheritDoc
     */
    public function dataTable(array $filters = []): JsonResponse
    {
        $patientData = $this->model->query();

        $patientData = $patientData->with('user');

        if ($filters['columnName'] && $filters['columnSortOrder']) {
            $patientData = $patientData->orderBy($filters['columnName'], $filters['columnSortOrder']);
        }

        return DataTables::of($patientData)
            ->editColumn('id', function ($data) {
                return '#OP' . $data->id;
            })
            ->editColumn('name', function ($data) {
                return $data?->user?->name;
            })
            ->addColumn('actions', function ($data) {
//                $deleteUrl = route('regain.patients.destroy', [
//                    'patientId' => $data->id,
//                ]);

                $html = '<div class="btn-group">';

//                $html .= '<a href="' . route('regain.patients.edit', $data->id) . '" class="btn btn-icon btn-gradient-warning">
//                             <i class="ti ti-edit ti-xs"></i>
//                        </a>';
//
//                $html .= '<a href="#" class="btn btn-icon btn-gradient-danger"
//                           data-bs-toggle="modal" data-bs-target="#deleteModal"
//                           onclick="deleteForm(\'' . $deleteUrl . '\')">
//                            <i class="ti ti-trash ti-xs"></i>
//                       </a>';

                $html .= '</div>';
                return $html;
            })
            ->makeHidden(['created_at', 'updated_at', 'deleted_at'])
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**
     * @inheritDoc
     */
    public function getTableColumns(): array
    {
        return  [
            'id'=> ['name' => 'id', 'table' => 'patient_data.id', 'searchable' => 'false', 'sortable' => 'true'],

            'name' => ['name' => 'name', 'table' => 'users.name', 'searchable' => 'false', 'sortable' => 'true'],

        ];

    }

}
