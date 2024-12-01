<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Http\Dtos;

class SubmittedUserResponseForm
{
    private int $questionId;
    /** @var int[] */
    private array $questionResponseIds;
    private int $userId;

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function setQuestionId(int $questionId): SubmittedUserResponseForm
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function getQuestionResponseIds(): array
    {
        return $this->questionResponseIds;
    }

    public function setQuestionResponseIds(array $questionResponseIds): SubmittedUserResponseForm
    {
        $this->questionResponseIds = $questionResponseIds;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): SubmittedUserResponseForm
    {
        $this->userId = $userId;

        return $this;
    }
}
