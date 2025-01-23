<?php

namespace App\Domains\Reports\Http\Presenters;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;

class FlowPresenter
{
    private QuestionnaireFlowType $flowType;
    private string $name;
    /**
     * @var TestPresenter[]
     */
    private array $tests = [];

    public function getFlowType(): QuestionnaireFlowType
    {
        return $this->flowType;
    }

    public function setFlowType(QuestionnaireFlowType $flowType): FlowPresenter
    {
        $this->flowType = $flowType;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): FlowPresenter
    {
        $this->name = $name;

        return $this;
    }

    public function getTests(): array
    {
        return $this->tests;
    }

    public function setTests(array $tests): FlowPresenter
    {
        $this->tests = $tests;

        return $this;
    }

    public function addTest(TestPresenter $test): FlowPresenter
    {
        $this->tests[] = $test;

        return $this;
    }
}
