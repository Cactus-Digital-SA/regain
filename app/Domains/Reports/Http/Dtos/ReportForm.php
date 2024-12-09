<?php

namespace App\Domains\Reports\Http\Dtos;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\QuestionnaireFlow\Models\QuestionnaireFlow;

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