<?php

namespace App\Domains\Reports\Http\Dtos;

use App\Domains\Tests\Models\Test;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;

class ReportTestResultSubscaleResult
{
    private string $resultLabel = "";
    private string $resultNotes;
    private string $subscaleName;
    private int $subscaleItems;
    private int $subscaleIndex = 0;

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

    public function getSubscaleItems(): int
    {
        return $this->subscaleItems;
    }

    public function setSubscaleItems(int $subscaleItems): ReportTestResultSubscaleResult
    {
        $this->subscaleItems = $subscaleItems;

        return $this;
    }

    public function getSubscaleIndex(): int
    {
        return $this->subscaleIndex;
    }

    public function setSubscaleIndex(int $subscaleIndex): ReportTestResultSubscaleResult
    {
        $this->subscaleIndex = $subscaleIndex;

        return $this;
    }
}