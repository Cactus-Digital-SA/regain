<?php

namespace App\Domains\Reports\Http\Dtos;

use App\Domains\Tests\Models\Test;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;

class ReportTestResult
{
    private Test $test;
    private ThresholdDisplayType $displayType;
    /**
     * @var ReportPlainResponse[]
     */
    private array $plainResponses;
    /**
     * @var ReportTestResultSubscaleResult[]
     */
    private array $subscaleResults = [];
    private ReportTestResultTotalResult $testResult;
    private int $subscaleItems = 0;

    public function getTest(): Test
    {
        return $this->test;
    }

    public function setTest(Test $test): ReportTestResult
    {
        $this->test = $test;

        return $this;
    }

    public function getDisplayType(): ThresholdDisplayType
    {
        return $this->displayType;
    }

    public function setDisplayType(ThresholdDisplayType $displayType): ReportTestResult
    {
        $this->displayType = $displayType;

        return $this;
    }

    /**
     * @return ReportPlainResponse[]
     */
    public function getPlainResponses(): array
    {
        return $this->plainResponses;
    }

    /**
     * @param ReportPlainResponse[] $plainResponses
     * @return $this
     */
    public function setPlainResponses(array $plainResponses): ReportTestResult
    {
        $this->plainResponses = $plainResponses;

        return $this;
    }

    public function addPlainResponse(ReportPlainResponse $response): ReportTestResult
    {
        $this->plainResponses[] = $response;

        return $this;
    }

    public function getSubscaleResults(): array
    {
        return $this->subscaleResults;
    }

    public function setSubscaleResults(array $subscaleResults): ReportTestResult
    {
        $this->subscaleResults = $subscaleResults;

        return $this;
    }

    public function getTestResult(): ReportTestResultTotalResult
    {
        return $this->testResult;
    }

    public function setTestResult(ReportTestResultTotalResult $testResult): ReportTestResult
    {
        $this->testResult = $testResult;

        return $this;
    }

    public function getSubscaleItems(): int
    {
        return $this->subscaleItems;
    }

    public function setSubscaleItems(int $subscaleItems): ReportTestResult
    {
        $this->subscaleItems = $subscaleItems;

        return $this;
    }
}