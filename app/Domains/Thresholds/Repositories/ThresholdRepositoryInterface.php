<?php

namespace App\Domains\Thresholds\Repositories;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\Thresholds\Models\Threshold;
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

    /**
     * @param QuestionnaireFlowType $type
     * @return Threshold[]
     */
    public function getThresholdsByFlow(QuestionnaireFlowType $type): array;

    public function getById(string $id): ?Threshold;

    public function addSubscaleLimits(Threshold $threshold, array $subscaleLimits): void;
}
