<?php

namespace App\Domains\UserQuestionnaire\Repositories\Eloquent;

use App\Domains\Patient\Models\PatientData;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\UserQuestionnaire\Models\UserQuestionnaire;
use App\Domains\UserQuestionnaire\Repositories\Eloquent\Models\UserQuestionnaire as UserQuestionnaireEloquent;
use App\Domains\UserQuestionnaire\Repositories\UserQuestionnaireRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use Illuminate\Http\JsonResponse;
use Nette\NotImplementedException;

class UserQuestionnaireRepository implements UserQuestionnaireRepositoryInterface
{
    /**
     * @param int                   $userId
     * @param QuestionnaireFlowType $flow
     * @return int[]
     */
    public function getForUserAndFlow(int $userId, QuestionnaireFlowType $flow): array
    {
        $questions = UserQuestionnaireEloquent::where("user_id", $userId)
                                              ->where("questionnaire_flow_type", $flow->value)
                                              ->get("generated_questions");
        if ($questions->isEmpty()) {
            return [];
        }

        return unserialize($questions[0]->generated_questions, ["allowed_classes" => true]);
    }

    public function get(): ?array
    {
        throw new NotImplementedException();
    }

    public function store(CactusEntity|UserQuestionnaire $entity): ?UserQuestionnaire
    {
        $userQuestionnaire = UserQuestionnaireEloquent::create([
            'user_id'                 => $entity->getUserId(),
            'questionnaire_flow_type' => $entity->getQuestionnaireFlowType()->value,
            'generated_questions'     => serialize($entity->getQuestionIds())
        ]);

        return ObjectSerializer::deserialize($userQuestionnaire?->toJson() ?? "{}", UserQuestionnaire::class, 'json');
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function getById(string $id): ?PatientData
    {
        throw new NotImplementedException();
    }

    public function updateByUserId(CactusEntity|PatientData $entity, string $userId): ?PatientData
    {
        throw new NotImplementedException();
    }

    public function deleteById(string $id): bool
    {
        throw new NotImplementedException();
    }

    public function dataTable(array $filters = []): JsonResponse
    {
        throw new NotImplementedException();
    }

    public function getTableColumns(): array
    {
        throw new NotImplementedException();
    }
}
