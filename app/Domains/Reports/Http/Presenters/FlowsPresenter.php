<?php

namespace App\Domains\Reports\Http\Presenters;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;

class FlowsPresenter
{
    /**
     * @var FlowPresenter[]
     */
    private array $flows;

    public function getFlows(): array
    {
        return $this->flows;
    }

    public function setFlows(array $flows): FlowsPresenter
    {
        $this->flows = $flows;

        return $this;
    }

    public function addFlow(FlowPresenter $flow): FlowsPresenter
    {
        $this->flows[] = $flow;

        return $this;
    }
}