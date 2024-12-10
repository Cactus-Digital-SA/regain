<?php

namespace App\Domains\UserQuestionnaire\Repositories;

use App\Domains\Patient\Models\PatientData;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\UserQuestionnaire\Models\UserQuestionnaire;
use App\Models\CactusEntity;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\JsonResponse;

interface UserQuestionnaireRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int                   $userId
     * @param QuestionnaireFlowType $flow
     * @return int[]
     */
    public function getQuestionsForUserAndFlow(int $userId, QuestionnaireFlowType $flow): array;

    public function store(UserQuestionnaire|CactusEntity $entity): ?CactusEntity;

    public function getCompleted(int $userId, QuestionnaireFlowType $flow): bool;

    public function setCompleted(int $userId, QuestionnaireFlowType $type, bool $completed): int;
}
