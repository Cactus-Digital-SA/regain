<?php

namespace App\Domains\Results\Services;

use App\Domains\Results\Models\Threshold;
use App\Domains\Results\Repositories\ThresholdRepositoryInterface;

class ThresholdService
{
    public function __construct(
        protected ThresholdRepositoryInterface $repository,
    ) {
    }

    public function store(Threshold $entity): Threshold
    {
        return $this->repository->store($entity);
    }
}
