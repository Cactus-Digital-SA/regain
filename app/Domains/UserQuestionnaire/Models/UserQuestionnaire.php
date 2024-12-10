<?php

namespace App\Domains\UserQuestionnaire\Models;

use App\Domains\Auth\Models\User;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\QuestionnaireFlow\Models\QuestionnaireFlow;
use App\Models\CactusEntity;

class UserQuestionnaire extends CactusEntity
{
    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;
    /**
     * @var int $userId
     * @JMS\Serializer\Annotation\SerializedName("user_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $userId;
    /**
     * @var QuestionnaireFlowType $questionnaireFlowType
     * @JMS\Serializer\Annotation\SerializedName("questionnaire_flow_id")
     * @JMS\Serializer\Annotation\Type("enum<'App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType'>")
     */
    private QuestionnaireFlowType $questionnaireFlowType;
    /**
     * @var int[] $questionIds
     * @JMS\Serializer\Annotation\SerializedName("questionIds")
     * @JMS\Serializer\Annotation\Type("array<int>")
     */
    private array $questionIds;
    /**
     * @var bool
     * @JMS\Serializer\Annotation\SerializedName("completed")
     * @JMS\Serializer\Annotation\Type("bool")
     */
    private bool $completed;
    /**
     * @var ?User $user
     * @JMS\Serializer\Annotation\SerializedName("user")
     * @JMS\Serializer\Annotation\Type("App\Domains\Auth\Models\User")
     */
    private ?User $user;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserQuestionnaire
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): UserQuestionnaire
    {
        $this->userId = $userId;

        return $this;
    }

    public function getQuestionnaireFlowType(): QuestionnaireFlowType
    {
        return $this->questionnaireFlowType;
    }

    public function setQuestionnaireFlowType(QuestionnaireFlowType $questionnaireFlowType): UserQuestionnaire
    {
        $this->questionnaireFlowType = $questionnaireFlowType;

        return $this;
    }

    public function getQuestionIds(): array
    {
        return $this->questionIds;
    }

    public function setQuestionIds(array $questionIds): UserQuestionnaire
    {
        $this->questionIds = $questionIds;

        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): UserQuestionnaire
    {
        $this->completed = $completed;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): UserQuestionnaire
    {
        $this->user = $user;

        return $this;
    }

    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'                      => $this->id,
            'userId'                  => $this->userId,
            'questionnaire_flow_type' => $this->questionnaireFlowType->value,
            'questionIds'             => $this->questionIds,
        ];

        if ($withRelations) {
            $data['user'] = $this->user;
        }

        return $data;
    }
}
