<?php

namespace App\Domains\Reports\Http\Dtos;

class ReportTestResultTotalResult
{
    private string $resultLabel;
    private string $resultNotes;

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
}