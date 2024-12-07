<?php

namespace App\Domains\Thresholds\Services;

use App\Domains\Thresholds\Repositories\ThresholdRepositoryInterface;
use App\Domains\Thresholds\Models\Threshold;

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
