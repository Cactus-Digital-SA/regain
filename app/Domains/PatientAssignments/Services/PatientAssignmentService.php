<?php

namespace App\Domains\PatientAssignments\Services;

use App\Domains\PatientAssignments\Models\PatientAssignment;
use App\Domains\PatientAssignments\Repositories\PatientAssignmentRepositoryInterface;

readonly class PatientAssignmentService
{
    public function __construct(
        private PatientAssignmentRepositoryInterface $repository
    ) {
    }

    public function getById(string $id): ?PatientAssignment
    {
        return $this->repository->getById($id);
    }

    /**
     * @param string $userId
     * @return PatientAssignment[]
     */
    public function getByPractitionerUserId(string $userId): array
    {
        return $this->repository->getByPractitionerUserId($userId);
    }

    public function getByPatientUserId(string $userId): ?PatientAssignment
    {
        return $this->repository->getByPatientUserId($userId);
    }

    public function store(PatientAssignment $entity): ?PatientAssignment
    {
        return $this->repository->store($entity);
    }

    public function assignPatientByRegion(string $patientUserId): void
    {
        $this->repository->assignPatientByRegion($patientUserId);
    }
}