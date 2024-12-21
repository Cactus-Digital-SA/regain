<?php

namespace App\Domains\Reports\Dtos\MedicalHistoryReport;

use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\PatientData;
use App\Domains\Reports\Dtos\PatientReport\ReportPlainResponse;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResultSubscaleResult;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResultTotalResult;
use App\Domains\Tests\Models\Test;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;

class  MedicalHistoryResult
{
    private Test $test;
    private User $user;
    private PatientData $patientData;
    /**
     * @var MedicalHistoryQuestionAnswer[]
     */
    private array $questionAnswers = [];

    public function getTest(): Test
    {
        return $this->test;
    }

    public function setTest(Test $test): MedicalHistoryResult
    {
        $this->test = $test;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): MedicalHistoryResult
    {
        $this->user = $user;

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
}