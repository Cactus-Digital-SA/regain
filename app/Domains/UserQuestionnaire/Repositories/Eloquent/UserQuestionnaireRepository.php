<?php

namespace App\Domains\UserQuestionnaire\Repositories\Eloquent;

use App\Domains\Patient\Models\PatientData;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\UserQuestionnaire\Models\UserQuestionnaire;
use App\Domains\UserQuestionnaire\Repositories\Eloquent\Models\UserQuestionnaire as UserQuestionnaireEloquent;
use App\Domains\UserQuestionnaire\Repositories\UserQuestionnaireRepositoryInterface;
use App\Facades\ObjectSerializer;
use App\Models\CactusEntity;
use DateTime;
use Illuminate\Http\JsonResponse;
use Nette\NotImplementedException;

class UserQuestionnaireRepository implements UserQuestionnaireRepositoryInterface
{
    /**
     * @param int                   $userId
     * @param QuestionnaireFlowType $flow
     * @return int[]
     */
    public function getQuestionsForUserAndFlow(int $userId, QuestionnaireFlowType $flow): array
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

    /**
     * @param int                   $userId
     * @param QuestionnaireFlowType $flow
     * @return bool
     */
    public function getCompleted(int $userId, QuestionnaireFlowType $flow): bool
    {
        return UserQuestionnaireEloquent::where("user_id", $userId)
                                        ->where("questionnaire_flow_type", $flow->value)
                                        ->pluck("completed")->first() ?? false;
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

    public function setCompleted(int $userId, QuestionnaireFlowType $type, bool $completed): int
    {
        return UserQuestionnaireEloquent::where([
            'user_id'                 => $userId,
            'questionnaire_flow_type' => $type->value,
        ])->update([
            'completed' => $completed
        ]);
    }

    public function update(CactusEntity $entity, string $id): ?CactusEntity
    {
        throw new NotImplementedException();
    }

    public function setCompletedForUser(int $userId, int $forUserId, QuestionnaireFlowType $type, bool $completed): void
    {
        UserQuestionnaireEloquent::updateOrCreate(
            [
                'user_id'                 => $userId,
                'questionnaire_flow_type' => $type->value,
                'for_user_id'             => $forUserId,
                'generated_questions'     => Serialize([])
            ],
            [
                'completed' => $completed
            ]
        );
    }

    public function getCompletedForUser(int $userId, int $forUserId, QuestionnaireFlowType $type): bool
    {
        $row = UserQuestionnaireEloquent::where(
            [
                'user_id'                 => $userId,
                'questionnaire_flow_type' => $type->value,
                'for_user_id'             => $forUserId,
            ],
        )->pluck('completed')->first();

        return $row === 1;
    }

    public function getMedicalHistoryCompletedForUser(int $userId): bool
    {
        $row = UserQuestionnaireEloquent::where(
            [
                'for_user_id'             => $userId,
                'questionnaire_flow_type' => QuestionnaireFlowType::MEDICAL_HISTORY->value,
            ],
        )->pluck('completed')->first();

        return $row === 1;
    }

    public function getMedicalHistoryCompletedAtForUser(int $practitionerId, int $userId): ?DateTime
    {
        return UserQuestionnaireEloquent::where(
            [
                'user_id'                 => $practitionerId,
                'for_user_id'             => $userId,
                'questionnaire_flow_type' => QuestionnaireFlowType::MEDICAL_HISTORY->value,
            ],
        )->pluck('created_at')->first();
    }

    /**
     * @param int $userId
     * @return int[]
     */
    public function getCompletedPatientFlows(int $userId): array
    {
        return UserQuestionnaireEloquent::where([
            'user_id'   => $userId,
            'completed' => true,
        ])->whereIn(
            'questionnaire_flow_type',
            [QuestionnaireFlowType::PRE_ASSESSMENT->value, QuestionnaireFlowType::SKILLS->value]
        )->pluck('questionnaire_flow_type')->toArray();
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

    public function dataTable(?int $userId = null, array $filters = []): JsonResponse
    {
        throw new NotImplementedException();
    }

    public function getTableColumns(): array
    {
        throw new NotImplementedException();
    }
}
