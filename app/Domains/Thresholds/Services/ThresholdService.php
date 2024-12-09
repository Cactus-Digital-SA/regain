<?php

namespace App\Domains\Thresholds\Services;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
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

    /**
     * @param QuestionnaireFlowType $flowType
     * @return Threshold[]
     */
    public function getThresholdsByFlow(QuestionnaireFlowType $flowType): array
    {
        return $this->repository->getThresholdsByFlow($flowType);
    }

    public function getById(int $id): ?Threshold
    {
        return $this->repository->getById($id);
    }

    public function addSubscaleLimits(Threshold $threshold, array $subscaleLimits): void
    {
        $this->repository->addSubscaleLimits($threshold, $subscaleLimits);
    }
}
