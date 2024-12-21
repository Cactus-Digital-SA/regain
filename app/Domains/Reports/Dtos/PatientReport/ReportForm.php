<?php

namespace App\Domains\Reports\Dtos\PatientReport;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;

class ReportForm
{
    private int $userId;
    private QuestionnaireFlowType $flowId;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): ReportForm
    {
        $this->userId = $userId;

        return $this;
    }

    public function getFlowId(): QuestionnaireFlowType
    {
        return $this->flowId;
    }

    public function setFlowId(int $flowId): ReportForm
    {
        $this->flowId = QuestionnaireFlowType::from($flowId);

        return $this;
    }
}