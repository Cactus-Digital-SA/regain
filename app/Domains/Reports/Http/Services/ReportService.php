<?php

namespace App\Domains\Reports\Http\Services;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\Reports\Http\Presenters\FlowPresenter;
use App\Domains\Reports\Http\Presenters\FlowsPresenter;
use App\Domains\Reports\Http\Presenters\TestPresenter;
use App\Domains\Scores\Repositories\Eloquent\UserTestScore;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use App\Domains\UserQuestionnaire\Services\UserQuestionnaireService;

class ReportService
{
    public function __construct(
        private readonly UserQuestionnaireService $userQuestionnaireService,
    ) {
    }

    public function getFlowPresenterForUser(int $userId): FlowsPresenter
    {
        $flows = $this->userQuestionnaireService->getCompletedPatientFlows($userId);

        $presenter = new FlowsPresenter();
        foreach ($flows as $flow) {
            $flowPresenter = new FlowPresenter();
            $flowPresenter->setFlowType(QuestionnaireFlowType::from($flow));
            $flowPresenter->setName($this->getFlowName(QuestionnaireFlowType::from($flow)));
            $tests = Test::whereIn('category_id', static function ($query) use ($flow) {
                $query->select("category_id")
                      ->from("questionnaire_flows")
                      ->where('flow_type', $flow);
            })->with('subscales')->get();

            foreach ($tests as $test) {
                if ($test->id > 6 && $test->subscales()->count() > 0) {
                    $testPresenter = new TestPresenter();

                    $completedAt = UserTestScore::where('user_id', $userId)
                                                ->where('test_id', $test->id)
                                                ->get("updated_at")->first()?->updated_at;

                    $flowPresenter
                        ->addTest(
                            $testPresenter
                                ->setId($test->id)
                                ->setName($test->name)
                                ->setCompletedAt($completedAt)
                        );
                }
            }
            $presenter->addFlow($flowPresenter);
        }

        return $presenter;
    }

    private function getFlowName(QuestionnaireFlowType $flow): string
    {
        return match ($flow) {
            QuestionnaireFlowType::PRE_ASSESSMENT => 'Pre-assessment Report',
            QuestionnaireFlowType::SKILLS         => 'Skills Report',
        };
    }
}
