<?php

namespace App\Domains\Reports\Http\Dtos;

class ReportResults
{
    /**
     * @var ReportTestResult[]
     */
    private array $testResults = [];

    public function getTestResults(): array
    {
        return $this->testResults;
    }

    public function setTestResults(array $testResults): ReportResults
    {
        $this->testResults = $testResults;

        return $this;
    }

    public function addTestResult(ReportTestResult $testResults): ReportResults
    {
        $this->testResults[] = $testResults;

        return $this;
    }
}