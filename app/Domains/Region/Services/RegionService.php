<?php

namespace App\Domains\Region\Services;

use App\Domains\References\Models\Reference;
use App\Domains\References\Repositories\ReferenceRepositoryInterface;
use App\Domains\Region\Models\Region;
use App\Domains\Region\Repositories\RegionRepositoryInterface;

class RegionService
{
    public function __construct(
        private readonly RegionRepositoryInterface $repository,
    ) {
    }

    /**
     * @return Region[]
     */
    public function get(): array
    {
        return $this->repository->get();
    }
}
