<?php

namespace App\Domains\Patient\Services;

use App\Domains\Patient\Enums\StatusEnum;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Patient\Repositories\PatientDataRepositoryInterface;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;

class PatientDataService
{
    public function __construct(private PatientDataRepositoryInterface $repository)
    {
    }

    public function get(): ?array
    {
        return $this->repository->get();
    }

    public function getById(string $id): ?PatientData
    {
        return $this->repository->getById($id);
    }

    public function getByUserId(string $userId): ?PatientData
    {
        return $this->repository->getByUserId($userId);
    }

    public function store(PatientData $entity): ?PatientData
    {
        return $this->repository->store($entity);
    }

    public function update(PatientData $entity, string $id): ?PatientData
    {
        return $this->repository->update($entity, $id);
    }

    public function updateStatus(string $userId, StatusEnum $status): void
    {
        $this->repository->updateStatus($userId, $status);
    }

    public function deleteById(string $id): bool
    {
        return $this->repository->deleteById($id);
    }

    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        return $this->repository->dataTable($userId, $filters);
    }

    public function getTableColumns(): array
    {
        return $this->repository->getTableColumns();
    }

    public function getTableColumnsNoRegion(): array
    {
        return $this->repository->getTableColumnsNoRegion();
    }

    public function emailExists(string $email): bool
    {
        return $this->repository->emailExists($email);
    }
}
