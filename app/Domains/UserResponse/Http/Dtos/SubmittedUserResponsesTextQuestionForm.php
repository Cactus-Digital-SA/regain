<?php

declare(strict_types = 1);

namespace App\Domains\UserResponse\Http\Dtos;

class SubmittedUserResponsesTextQuestionForm
{
    private int $questionId;
    private string $textResponse;

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function setQuestionId(int $questionId): SubmittedUserResponsesTextQuestionForm
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function getTextResponse(): string
    {
        return $this->textResponse;
    }

    public function setTextResponse(string $textResponse): SubmittedUserResponsesTextQuestionForm
    {
        $this->textResponse = $textResponse;

        return $this;
    }
}
