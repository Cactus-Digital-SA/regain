<?php

namespace App\Domains\Reports\Dtos\PatientReport;

class ReportTestResultTotalResult
{
    private string $resultLabel;
    private string $resultNotes;
    private int $score;

    public function getResultLabel(): string
    {
        return $this->resultLabel;
    }

    public function setResultLabel(string $resultLabel): ReportTestResultTotalResult
    {
        $this->resultLabel = $resultLabel;

        return $this;
    }

    public function getResultNotes(): string
    {
        return $this->resultNotes;
    }

    public function setResultNotes(string $resultNotes): ReportTestResultTotalResult
    {
        $this->resultNotes = $resultNotes;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): ReportTestResultTotalResult
    {
        $this->score = $score;

        return $this;
    }
}