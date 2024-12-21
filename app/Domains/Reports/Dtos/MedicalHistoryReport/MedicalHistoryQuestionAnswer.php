<?php

namespace App\Domains\Reports\Dtos\MedicalHistoryReport;

class MedicalHistoryQuestionAnswer
{
    private string $questionText;
    private string $answerText;

    public function getQuestionText(): string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): MedicalHistoryQuestionAnswer
    {
        $this->questionText = $questionText;

        return $this;
    }

    public function getAnswerText(): string
    {
        return $this->answerText;
    }

    public function setAnswerText(string $answerText): MedicalHistoryQuestionAnswer
    {
        $this->answerText = $answerText;

        return $this;
    }
}