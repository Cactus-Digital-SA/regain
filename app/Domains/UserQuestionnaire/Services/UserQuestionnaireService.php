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
        return $this->repository->getQuestionsForUserAndFlow($userId, $flow);
    }

    public function store(CactusEntity $entity): ?CactusEntity
    {
        return $this->repository->store($entity);
    }

    public function getCompleted(int $userId, QuestionnaireFlowType $flow): bool
    {
        return $this->repository->getCompleted($userId, $flow);
    }

    public function setCompleted(int $userId, QuestionnaireFlowType $flow, bool $completed): int
    {
        return $this->repository->setCompleted($userId, $flow, $completed);
    }

    public function setCompletedForUser(int $userId, int $forUserId, QuestionnaireFlowType $flow, bool $completed): void
    {
        $this->repository->setCompletedForUser($userId, $forUserId, $flow, $completed);
    }

    public function getCompletedForUser(int $userId, int $forUserId, QuestionnaireFlowType $flow): bool
    {
        return $this->repository->getCompletedForUser($userId, $forUserId, $flow);
    }

    public function getCompletedForUserAsUser(int $userId, QuestionnaireFlowType $flow): bool
    {
        return $this->repository->getCompletedForUserAsUser($userId, $flow);
    }

    /**
     * @param int $userId
     * @return int[]
     */
    public function getCompletedPatientFlows(int $userId): array
    {
        return $this->repository->getCompletedPatientFlows($userId);
    }
}
