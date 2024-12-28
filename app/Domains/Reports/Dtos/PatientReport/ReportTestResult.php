<?php

namespace App\Domains\Reports\Dtos\PatientReport;

use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Tests\Models\Test;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;
use DateTime;

class ReportTestResult
{
    private Test $test;
    private ThresholdDisplayType $displayType;
    private User $user;
    private PatientData $patientData;
    private DateTime $completedAt;
    /**
     * @var ReportPlainResponse[]
     */
    private array $plainResponses;
    /**
     * @var ReportTestResultSubscaleResult[]
     */
    private array $subscaleResults = [];
    private ?ReportTestResultTotalResult $testResult = null;
    private int $subscaleItems = 0;
    private string $description =         'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): ReportTestResult
    {
        $this->user = $user;

        return $this;
    }

    public function getPatientData(): PatientData
    {
        return $this->patientData;
    }

    public function setPatientData(PatientData $patientData): ReportTestResult
    {
        $this->patientData = $patientData;

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

    public function getTestResult(): ?ReportTestResultTotalResult
    {
        return $this->testResult;
    }

    public function setTestResult(?ReportTestResultTotalResult $testResult): ReportTestResult
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): ReportTestResult
    {
        $this->description = $description;

        return $this;
    }

    public function getCompletedAt(): DateTime
    {
        return $this->completedAt;
    }

    public function setCompletedAt(DateTime $completedAt): ReportTestResult
    {
        $this->completedAt = $completedAt;

        return $this;
    }
}
