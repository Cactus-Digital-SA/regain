<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Questions\Models\QuestionResponse;
use App\Domains\Subscales\Models\Subscale;
use App\Models\CactusEntityInterface;

class UserResponse implements CactusEntityInterface
{
    /**
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $id;
    /**
     * @JMS\Serializer\Annotation\SerializedName("user_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $userId;
    /**
     * @JMS\Serializer\Annotation\SerializedName("subscale_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $subscaleId;
    /**
     * @JMS\Serializer\Annotation\SerializedName("question_response_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $questionResponseId;
    /**
     * @JMS\Serializer\Annotation\SerializedName("score")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $score;
    /**
     * @JMS\Serializer\Annotation\SerializedName("user")
     * @JMS\Serializer\Annotation\Type("App\Domains\Auth\Models\User")
     */
    private ?User $user;
    /**
     * @JMS\Serializer\Annotation\SerializedName("subscale")
     * @JMS\Serializer\Annotation\Type("App\Domains\Subscales\Models\Subscale")
     */
    private ?Subscale $subscale;
    /**
     * @JMS\Serializer\Annotation\SerializedName("question_response")
     * @JMS\Serializer\Annotation\Type("App\Domains\Questions\Models\QuestionResponse")
     */
    private ?QuestionResponse $questionResponse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): UserResponse
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): UserResponse
    {
        $this->userId = $userId;

        return $this;
    }

    public function getSubscaleId(): ?int
    {
        return $this->subscaleId;
    }

    public function setSubscaleId(?int $subscaleId): UserResponse
    {
        $this->subscaleId = $subscaleId;

        return $this;
    }

    public function getQuestionResponseId(): ?int
    {
        return $this->questionResponseId;
    }

    public function setQuestionResponseId(?int $questionResponseId): UserResponse
    {
        $this->questionResponseId = $questionResponseId;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): UserResponse
    {
        $this->score = $score;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): UserResponse
    {
        $this->user = $user;

        return $this;
    }

    public function getSubscale(): ?Subscale
    {
        return $this->subscale;
    }

    public function setSubscale(?Subscale $subscale): UserResponse
    {
        $this->subscale = $subscale;

        return $this;
    }

    public function getQuestionResponse(): ?QuestionResponse
    {
        return $this->questionResponse;
    }

    public function setQuestionResponse(?QuestionResponse $questionResponse): UserResponse
    {
        $this->questionResponse = $questionResponse;

        return $this;
    }

    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'                   => $this->id,
            'user_id'              => $this->userId,
            'subscale_id'          => $this->subscaleId,
            'question_response_id' => $this->questionResponseId,
            'score'                => $this->score,
        ];

        if ($withRelations) {
            $data['user']              = $this->getUser();
            $data['subscale']          = $this->getSubscale();
            $data['question_response'] = $this->getQuestionResponse();
        }

        return $data;
    }
}
