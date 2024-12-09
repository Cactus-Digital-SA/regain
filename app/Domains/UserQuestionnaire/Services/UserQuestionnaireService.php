<?php

namespace App\Domains\UserQuestionnaire\Services;

use App\Domains\Patient\Repositories\PatientDataRepositoryInterface;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\UserQuestionnaire\Repositories\UserQuestionnaireRepositoryInterface;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;

class UserQuestionnaireService
{
    public function __construct(private UserQuestionnaireRepositoryInterface $repository)
    {
    }

    /**
     * @param int                   $userId
     * @param QuestionnaireFlowType $flow
     * @return int[]
     */
    public function getForUserAndFlow(int $userId, QuestionnaireFlowType $flow): array
    {
        return $this->repository->getForUserAndFlow($userId, $flow);
    }

    public function store(CactusEntity $entity): ?CactusEntity
    {
        return $this->repository->store($entity);
    }
}
