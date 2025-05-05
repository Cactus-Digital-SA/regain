<?php

namespace App\Domains\Reports\Dtos\PatientReport;

class ReportTestResultTotalResult
{
    private string $resultLabel;
    private string $resultNotes;
    private int $score;
    private int $testItems;
    private int $testIndex;
    private bool $alternatePrompt = false;

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

    public function getTestItems(): int
    {
        return $this->testItems;
    }

    public function setTestItems(int $testItems): ReportTestResultTotalResult
    {
        $this->testItems = $testItems;

        return $this;
    }

    public function getTestIndex(): int
    {
        return $this->testIndex;
    }

    public function setTestIndex(int $testIndex): ReportTestResultTotalResult
    {
        $this->testIndex = $testIndex;

        return $this;
    }

    public function getAlternatePrompt(): bool
    {
        return $this->alternatePrompt;
    }

    public function setAlternatePrompt(bool $alternatePrompt): ReportTestResultTotalResult
    {
        $this->alternatePrompt = $alternatePrompt;
        return $this;
    }
}
