<?php

namespace App\Domains\Results\Repositories;

use App\Domains\Results\Models\Threshold;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;

interface ThresholdRepositoryInterface extends RepositoryInterface
{

    /**
     * @param Threshold|CactusEntity $entity
     * @return Threshold
     */
    public function store(Threshold|CactusEntity $entity): Threshold;


    /**
     * @param Threshold|CactusEntity $entity
     * @return Threshold
     */
    public function findOrCreate(Threshold|CactusEntity $entity): Threshold;
}
