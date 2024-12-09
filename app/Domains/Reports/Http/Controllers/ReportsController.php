<?php

namespace App\Domains\Reports\Http\Controllers;

use App\Domains\Reports\Http\Dtos\ReportPlainResponse;
use App\Domains\Reports\Http\Dtos\ReportResults;
use App\Domains\Reports\Http\Dtos\ReportTestResult;
use App\Domains\Reports\Http\Dtos\ReportTestResultSubscaleResult;
use App\Domains\Reports\Http\Dtos\ReportTestResultTotalResult;
use App\Domains\Reports\Http\Requests\ReportRequest;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;
use App\Domains\Thresholds\Services\ThresholdService;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportsController
{
    public function __construct(
        private ThresholdService $thresholdService,
    ) {
    }

    public function report(ReportRequest $request): View
    {
        $form = $request->getReportForm();

        $thresholds = $this->thresholdService->getThresholdsByFlow($form->getFlowId());

        $result = new ReportResults();

        foreach ($thresholds as $threshold) {
            $test = $threshold->getTest();
            if ($test === null) {
                continue;
            }
            $testResult = (new ReportTestResult())->setTest($test);
            $testResult->setDisplayType($threshold->getDisplayType());

            if ($threshold->getDisplayType() === ThresholdDisplayType::DISPLAY) {
                $responses = UserResponse::join('question_response', 'question_response.id', '=', 'user_responses.question_response_id')
                                         ->join('responses', 'question_response.response_id', '=', 'responses.id')
                                         ->join('questions', 'questions.id', '=', 'user_responses.question_id')
                                         ->where('user_responses.user_id', $form->getUserId())  // Filter by user_id
                                         ->whereBetween('user_responses.question_id', [$threshold->getQuestionStart(), $threshold->getQuestionEnd()])  // Filter question_id between 14 and 16
                                         ->select(['questions.title as question_title', 'responses.title as response_title'])  // Select desired columns
                                         ->get();

                foreach ($responses as $response) {
                    $testResult->addPlainResponse((new ReportPlainResponse())
                        ->setQuestion($response->question_title)
                        ->setAnswer($response->response_title)
                    );
                }
                $result->addTestResult($testResult);
            } else {
                $totalScoreResult = DB::select("SELECT label, notes
                FROM (
                    SELECT threshold_test_limits.*, 
                    (SELECT score FROM user_test_scores WHERE user_id = ? AND test_id = ?) AS userScore
                    FROM threshold_test_limits
                    INNER JOIN thresholds ON thresholds.id = threshold_test_limits.threshold_id
                    WHERE thresholds.test_id = ?
                ) AS final
                WHERE final.userScore BETWEEN final.low AND final.high
                 ", [$form->getUserId(), $test->getId(), $test->getId()]);
                if (count($totalScoreResult) === 1) {
                    $testResult->setTestResult((new ReportTestResultTotalResult())
                        ->setResultLabel($totalScoreResult[0]->label)
                        ->setResultNotes($totalScoreResult[0]->notes ?? "")
                    );
                }

                if ($threshold->getDisplayType() === ThresholdDisplayType::SUBSCALE_SCORE) {
                    $subscales = $test->getSubscales();
                    if (count($subscales) > 0) {
                        $subscaleResults = [];
                        foreach ($subscales as $subscale) {
                            $subscalesList  = DB::select("
        SELECT
            ROW_NUMBER() OVER (ORDER BY threshold_subscale_limits.low) AS row_index,
            threshold_subscale_limits.*, 
            (SELECT score FROM user_subscale_scores WHERE user_id = ? AND subscale_id = ?) AS user_score 
        FROM threshold_subscale_limits
        INNER JOIN thresholds ON thresholds.id = threshold_subscale_limits.threshold_id
        WHERE thresholds.test_id = ?", [$form->getUserId(), $subscale->getId(), $test->getId()]);
                            $subscaleResult = new ReportTestResultSubscaleResult();
                            $testResult->setSubscaleItems(count($subscalesList));
                            $subscaleResult->setSubscaleName($subscale->getName());
                            foreach ($subscalesList as $subscaleListItem) {
                                if ($subscaleListItem->user_score >= $subscaleListItem->low && $subscaleListItem->user_score <= $subscaleListItem->high) {
                                    $subscaleResult->setResultLabel($subscaleListItem->label);
                                    $subscaleResult->setResultNotes($subscaleListItem->notes ?? "");
                                    $subscaleResult->setSubscaleIndex($subscaleListItem->row_index);
                                }
                            }
                            $subscaleResults[] = $subscaleResult;
                        }
                        $testResult->setSubscaleResults($subscaleResults);
                    }
                }
                $result->addTestResult($testResult);
            }
        }

        return view('reports.flows.result')->with(
            ["result" => $result]
        );
    }
}