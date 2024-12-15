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

    public function getById(string $id): ?CactusEntity
    {
        return $this->repository->getById($id);
    }

    public function getByUserId(string $userId): ?CactusEntity
    {
        return $this->repository->getByUserId($userId);
    }

    public function store(CactusEntity $entity): ?CactusEntity
    {
        return $this->repository->store($entity);
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
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
}
