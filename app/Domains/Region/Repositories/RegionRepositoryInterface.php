<?php

namespace App\Domains\Region\Repositories;

use App\Domains\Region\Models\Region;
use App\Repositories\RepositoryInterface;

interface RegionRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Region[]
     */
    public function get(): array;
}