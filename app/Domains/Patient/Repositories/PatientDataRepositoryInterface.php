<?php

namespace App\Domains\Patient\Repositories;

use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\RolesEnum;
use App\Domains\Auth\Models\User;
use App\Domains\Patient\Enums\StatusEnum;
use App\Domains\Patient\Models\PatientData;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\JsonResponse;

interface PatientDataRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array|null
     */
    public function get(): ?array;

    /**
     * @param string $id
     * @return PatientData|null
     */
    public function getById(string $id): ?PatientData;

    /**
     * @param CactusEntity|PatientData $entity
     * @return PatientData|null
     */
    public function store(CactusEntity|PatientData $entity): ?PatientData;

    /**
     * @param CactusEntity|PatientData $entity
     * @param string                   $userId
     * @return PatientData|null
     */
    public function updateByUserId(CactusEntity|PatientData $entity, string $userId): ?PatientData;

    /**
     * @param string $id
     * @return bool
     */
    public function deleteById(string $id): bool;

    /**
     * @param array $filters
     * @return JsonResponse
     */
    public function dataTable(?int $userId = null, array $filters = []): JsonResponse;

    /**
     * @return array
     */
    public function getTableColumns(): array;

    public function getByUserId(string $userId): ?PatientData;

    public function updateStatus(string $userId, StatusEnum $status): void;
}
