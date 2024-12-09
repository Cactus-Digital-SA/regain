<?php

namespace App\Domains\Reports\Http\Dtos;

use App\Domains\Tests\Models\Test;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;

class ReportTestResultSubscaleResult
{
    private string $resultLabel;
    private string $resultNotes;
    private string $subscaleName;

    public function getResultLabel(): string
    {
        return $this->resultLabel;
    }

    public function setResultLabel(string $resultLabel): ReportTestResultSubscaleResult
    {
        $this->resultLabel = $resultLabel;

        return $this;
    }

    public function getResultNotes(): string
    {
        return $this->resultNotes;
    }

    public function setResultNotes(string $resultNotes): ReportTestResultSubscaleResult
    {
        $this->resultNotes = $resultNotes;

        return $this;
    }

    public function getSubscaleName(): string
    {
        return $this->subscaleName;
    }

    public function setSubscaleName(string $subscaleName): ReportTestResultSubscaleResult
    {
        $this->subscaleName = $subscaleName;

        return $this;
    }
}