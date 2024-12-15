<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Http\Dtos;

class SubmittedUserResponsesForm
{
    /** @var SubmittedUserResponsesQuestionForm[] */
    private array $questions = [];
    /**
     * @var SubmittedUserResponsesTextQuestionForm[]
     */
    private array $textQuestions = [];
    private int $userId;
    private ?int $forUserId = null;

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

    /**
     * @return SubmittedUserResponsesTextQuestionForm[]
     */
    public function getTextQuestions(): array
    {
        return $this->textQuestions;
    }

    /**
     * @param SubmittedUserResponsesTextQuestionForm[] $textQuestions
     * @return $this
     */
    public function setTextQuestions(array $textQuestions): SubmittedUserResponsesForm
    {
        $this->textQuestions = $textQuestions;

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

    public function getForUserId(): ?int
    {
        return $this->forUserId;
    }

    public function setForUserId(?int $forUserId): SubmittedUserResponsesForm
    {
        $this->forUserId = $forUserId;

        return $this;
    }
}
