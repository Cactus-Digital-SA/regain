<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Http\Dtos;

class SubmittedUserResponsesForm
{
    /** @var SubmittedUserResponsesQuestionForm[] */
    private array $questions = [];
    private int $userId;

    /**
     * @return SubmittedUserResponsesQuestionForm[]
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param SubmittedUserResponsesQuestionForm[] $questions
     * @return $this
     */
    public function setQuestions(array $questions): SubmittedUserResponsesForm
    {
        $this->questions = $questions;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): SubmittedUserResponsesForm
    {
        $this->userId = $userId;

        return $this;
    }
}
