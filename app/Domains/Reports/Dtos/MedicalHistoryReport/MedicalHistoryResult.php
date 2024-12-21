<?php

namespace App\Domains\Reports\Dtos\MedicalHistoryReport;

use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Reports\Dtos\PatientReport\ReportPlainResponse;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResultSubscaleResult;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResultTotalResult;
use App\Domains\Tests\Models\Test;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;
use DateTime;

class  MedicalHistoryResult
{
    private Test $test;
    private PatientData $patientData;
    /**
     * @var MedicalHistoryQuestionAnswer[]
     */
    private array $questionAnswers = [];
    private DateTime $completedAt;

    public function getTest(): Test
    {
        return $this->test;
    }

    public function setTest(Test $test): MedicalHistoryResult
    {
        $this->test = $test;

        return $this;
    }

    public function getPatientData(): PatientData
    {
        return $this->patientData;
    }

    public function setPatientData(PatientData $patientData): MedicalHistoryResult
    {
        $this->patientData = $patientData;

        return $this;
    }

    public function getQuestionAnswers(): array
    {
        return $this->questionAnswers;
    }

    public function setQuestionAnswers(array $questionAnswers): MedicalHistoryResult
    {
        $this->questionAnswers = $questionAnswers;

        return $this;
    }

    public function addQuestionAnswer(MedicalHistoryQuestionAnswer $questionAnswer): MedicalHistoryResult
    {
        $this->questionAnswers[] = $questionAnswer;

        return $this;
    }

    public function getCompletedAt(): DateTime
    {
        return $this->completedAt;
    }

    public function setCompletedAt(DateTime $completedAt): MedicalHistoryResult
    {
        $this->completedAt = $completedAt;

        return $this;
    }
}