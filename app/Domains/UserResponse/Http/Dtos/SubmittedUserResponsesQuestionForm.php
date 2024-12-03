<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Http\Dtos;

class SubmittedUserResponsesQuestionForm
{
    private int $questionId;
    /**
     * @var int[]
     */
    private array $responseIds;

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function setQuestionId(int $questionId): SubmittedUserResponsesQuestionForm
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function getResponseIds(): array
    {
        return $this->responseIds;
    }

    public function setResponseIds(array $responseIds): SubmittedUserResponsesQuestionForm
    {
        $this->responseIds = $responseIds;

        return $this;
    }
}
