<?php

namespace App\Domains\Questions\Models;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;

class QuestionsPresenter
{
    /**
     * @var Question[]
     */
    private array $questions = [];
    private QuestionnaireFlowType $type;
    private bool $completed = false;

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function setQuestions(array $questions): QuestionsPresenter
    {
        $this->questions = $questions;

        return $this;
    }

    public function getType(): QuestionnaireFlowType
    {
        return $this->type;
    }

    public function setType(QuestionnaireFlowType $type): QuestionsPresenter
    {
        $this->type = $type;

        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): QuestionsPresenter
    {
        $this->completed = $completed;

        return $this;
    }
}