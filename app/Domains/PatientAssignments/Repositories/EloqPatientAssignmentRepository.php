<?php

namespace App\Domains\PatientAssignments\Repositories;

use App\Domains\Patient\Repositories\Eloquent\Models\PatientData;
use App\Domains\PatientAssignments\Models\PatientAssignment;
use App\Domains\PatientAssignments\Repositories\Models\PatientAssignment as EloqModel;
use App\Domains\Practitioner\Repositories\Eloquent\Models\Practitioner;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Nette\NotImplementedException;

readonly class EloqPatientAssignmentRepository implements PatientAssignmentRepositoryInterface
{
    protected Models\PatientAssignment $model;

    public function __construct(EloqModel $model)
    {
        $this->model = $model;
    }

    public function getById(string $id): ?PatientAssignment
    {
        $patientData = $this->model::find($id)?->load('practitionerUser', 'patientUser');

        return ObjectSerializer::deserialize($patientData?->toJson() ?? "{}", PatientAssignment::class, 'json');
    }

    /**
     * @param string $userId
     * @return PatientAssignment[]
     */
    public function getByPractitionerUserId(string $userId): array
    {
        $model = $this->model::where('practitioner_user_id', $userId)->with("patientUser", "practitionerUser")->get();
        if ($model) {
            return ObjectSerializer::deserialize($model?->toJson() ?? "{}", "array<" . PatientAssignment::class . ">", 'json');
        }

        return [];
    }

    /**
     * @param string $userId
     * @return ?PatientAssignment
     */
    public function getByPatientUserId(string $userId): ?PatientAssignment
    {
        $model = $this->model::where('patient_user_id', $userId)->with("patientUser", "practitionerUser")->first();
        if ($model) {
            return ObjectSerializer::deserialize($model?->toJson() ?? "{}", "<" . PatientAssignment::class . ">", 'json');
        }

        return null;
    }

    public function assignPatientByRegion(string $patientUserId): void
    {
        $patientRegion        = PatientData::where('user_id', "=", $patientUserId)->first()?->region_id;
        $practitionerByRegion = Practitioner::where("region_id", "=", $patientRegion)->first();

        $values = [
            'practitioner_user_id' => $practitionerByRegion->user_id,
            'patient_user_id'      => $patientUserId,
        ];
        $this->model->firstOrCreate($values, $values);
    }

    public function store(PatientAssignment|CactusEntity $entity): ?PatientAssignment
    {
        $patientData = $this->model::create([
            'practitioner_user_id' => $entity->getPractitionerId(),
            'patient_user_id'      => $entity->getPatientUserId(),
        ]);

        return ObjectSerializer::deserialize($patientData?->toJson() ?? "{}", PatientAssignment::class, 'json');
    }

    /**
     * @return PatientAssignment[]
     */
    public function getAllocatedPatients(): array
    {
        $model = $this->model::all();

        return ObjectSerializer::deserialize($model?->toJson() ?? "{}", "array<" . PatientAssignment::class . ">", 'json');
    }

    public function get(): ?array
    {
        throw new NotImplementedException();
    }

    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        throw new NotImplementedException();
    }

    public function getTableColumns(): array
    {
        throw new NotImplementedException();
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function deleteById(string $id): bool
    {
        throw new NotImplementedException();
    }
}
