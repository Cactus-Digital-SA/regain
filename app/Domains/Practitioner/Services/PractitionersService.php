<?php

namespace App\Domains\Practitioner\Services;

use App\Domains\Patient\Repositories\PatientDataRepositoryInterface;
use App\Domains\Practitioner\Model\Practitioner;
use App\Domains\Practitioner\Repositories\PractitionerRepositoryInterface;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;

class PractitionersService
{
    public function __construct(private PractitionerRepositoryInterface $repository)
    {
    }

    public function getById(string $userId): Practitioner
    {
        return $this->repository->getById($userId);
    }

    public function getTableColumns(): array
    {
        return $this->repository->getTableColumns();
    }
}
