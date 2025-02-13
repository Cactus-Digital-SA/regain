<?php

namespace App\Domains\PatientAssignments\Repositories;

use App\Domains\Patient\Models\PatientData;
use App\Domains\PatientAssignments\Models\PatientAssignment;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\JsonResponse;

interface PatientAssignmentRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array|null
     */
    public function get(): ?array;

    public function getById(string $id): ?PatientAssignment;

    /**
     * @param string $userId
     * @return PatientAssignment[]
     */
    public function getByPractitionerUserId(string $userId): array;

    /**
     * @param string $userId
     * @return PatientData|null
     */
    public function getByPatientUserId(string $userId): ?PatientAssignment;

    /**
     * @param int|null $userId
     * @param array    $filters
     * @return JsonResponse
     */
    public function dataTable(?int $userId = null, array $filters = []): JsonResponse;

    public function assignPatientByRegion(string $patientUserId): void;

    public function store(PatientAssignment|CactusEntity $entity): ?PatientAssignment;

    /**
     * @return array
     */
    public function getTableColumns(): array;

    /**
     * @return PatientAssignment[]
     */
    public function getAllocatedPatients(): array;
}
