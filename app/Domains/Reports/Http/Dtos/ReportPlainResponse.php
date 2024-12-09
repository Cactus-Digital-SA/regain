<?php

namespace App\Domains\Reports\Http\Dtos;

class ReportPlainResponse
{
    private string $question;
    private string $answer;

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): ReportPlainResponse
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): ReportPlainResponse
    {
        $this->answer = $answer;

        return $this;
    }
}