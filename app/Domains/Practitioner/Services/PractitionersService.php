<?php

namespace App\Domains\Practitioner\Services;

use App\Domains\Patient\Repositories\PatientDataRepositoryInterface;
use App\Domains\Practitioner\Models\Practitioner;
use App\Domains\Practitioner\Repositories\PractitionerRepositoryInterface;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;

class PractitionersService
{
    public function __construct(private PractitionerRepositoryInterface $repository)
    {
    }

    public function getById(string $id): Practitioner
    {
        return $this->repository->getById($id);
    }

    public function getByUserId(string $userId): Practitioner
    {
        return $this->repository->getByUserId($userId);
    }
}
