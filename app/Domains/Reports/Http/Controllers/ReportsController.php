<?php

namespace App\Domains\Reports\Http\Controllers;

use App\Domains\Auth\Services\UserService;
use App\Domains\Patient\Services\PatientDataService;
use App\Domains\PatientAssignments\Services\PatientAssignmentService;
use App\Domains\QuestionnaireFlow\QuestionnaireFlowService;
use App\Domains\Reports\Dtos\PatientReport\ReportPlainResponse;
use App\Domains\Reports\Dtos\PatientReport\ReportResults;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResult;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResultSubscaleResult;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResultTotalResult;
use App\Domains\Reports\Http\Requests\ReportRequest;
use App\Domains\Reports\Http\Services\ReportService;
use App\Domains\Tests\Services\TestService;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;
use App\Domains\Thresholds\Services\ThresholdService;
use App\Domains\UserQuestionnaire\Services\UserQuestionnaireService;
use App\Domains\UserResponse\Repositories\Eloquent\Models\UserResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use OpenAI\Client;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

readonly class ReportsController
{
    public function __construct(
        private ThresholdService $thresholdService,
        private TestService $testService,
        private PatientAssignmentService $patientAssignmentService,
        private UserService $userService,
        private PatientDataService $patientDataService,
//        private Client $openAIClient,
        private ReportService $reportService,
        private UserQuestionnaireService $userQuestionnaireService,
        private QuestionnaireFlowService $questionnaireFlowService,
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
                    (SELECT score FROM user_test_scores WHERE user_id = ? AND test_id = ?) AS user_score
                    FROM threshold_test_limits
                    INNER JOIN thresholds ON thresholds.id = threshold_test_limits.threshold_id
                    WHERE thresholds.test_id = ?
                ) AS final
                WHERE final.user_score BETWEEN final.low AND final.high
                 ", [$form->getUserId(), $test->getId(), $test->getId()]);
                if (count($totalScoreResult) === 1) {
                    $testResult->setTestResult((new ReportTestResultTotalResult())
                        ->setResultLabel($totalScoreResult[0]->label)
                        ->setResultNotes($totalScoreResult[0]->notes ?? "")
                        ->setScore($totalScoreResult[0]->user_score ?? 0)
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

    public function testReport(Request $request, string $userId, string $testId): BinaryFileResponse
    {
        $threshold = $this->thresholdService->getThresholdByTest($testId);

        if ($threshold === null) {
            throw new AuthorizationException("Threshold for test $testId not found.");
        }

        $test                = $this->testService->getById((int)$testId);
        $assignedPatients    = $this->patientAssignmentService->getByPractitionerUserId(Auth::id());
        $practitionerUserIds = array_map(static fn ($user) => $user->getPatientUserId(), $assignedPatients);

        // Check if $userId is in the list of practitioner user IDs
        if (!in_array((int)$userId, $practitionerUserIds, true)) {
            throw new AuthorizationException("User ID $userId is not authorized to access this report.");
        }

        // Check if the file already exists
        $filePath = $this->reportService->getFilePath(Auth::id(), $userId, $testId);
        if (($filePath !== null) && Storage::exists($filePath)) {
            return response()->download(storage_path("app/$filePath"), "report.pdf", [
                'Content-Type' => 'application/pdf',
            ]);
        }

        $result = new ReportTestResult();
        $result->setTest($test);

        if ($threshold->getDisplayType() === ThresholdDisplayType::DISPLAY) {
            $responses = UserResponse::join('question_response', 'question_response.id', '=', 'user_responses.question_response_id')
                                     ->join('responses', 'question_response.response_id', '=', 'responses.id')
                                     ->join('questions', 'questions.id', '=', 'user_responses.question_id')
                                     ->where('user_responses.user_id', $userId)  // Filter by user_id
                                     ->whereBetween('user_responses.question_id', [$threshold->getQuestionStart(), $threshold->getQuestionEnd()])  // Filter question_id between 14 and 16
                                     ->select(['questions.title as question_title', 'responses.title as response_title'])  // Select desired columns
                                     ->get();

            foreach ($responses as $response) {
                $result->addPlainResponse((new ReportPlainResponse())
                    ->setQuestion($response->question_title)
                    ->setAnswer($response->response_title)
                );
            }
        } else {
            $totalScoreResult = DB::select("SELECT label, notes
                FROM (
                    SELECT threshold_test_limits.*,
                    (SELECT score FROM user_test_scores WHERE user_id = ? AND test_id = ?) AS user_score
                    FROM threshold_test_limits
                    INNER JOIN thresholds ON thresholds.id = threshold_test_limits.threshold_id
                    WHERE thresholds.test_id = ?
                ) AS final
                WHERE final.user_score BETWEEN final.low AND final.high
                 ", [$userId, $testId, $testId]);
            if (count($totalScoreResult) === 1) {
                $result->setTestResult((new ReportTestResultTotalResult())
                    ->setResultLabel($totalScoreResult[0]->label)
                    ->setResultNotes($totalScoreResult[0]->notes ?? "")
                    ->setScore($totalScoreResult[0]->user_score ?? 0)
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
        WHERE thresholds.test_id = ? AND threshold_subscale_limits.subscale_id = ?", [$userId, $subscale->getId(), $test->getId(), $subscale->getId()]);
                        $subscaleResult = new ReportTestResultSubscaleResult();
                        $result->setSubscaleItems(count($subscalesList));
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
                    $result->setSubscaleResults($subscaleResults);
                }
            }
        }

        $result->setUser($this->userService->getById($userId));
        $result->setPatientData($this->patientDataService->getByUserId($userId));

        $sanitizeResults = implode("\n", array_map(static function ($item) {
            return "test subscale: " . $item->getSubscaleName() . " result: " . $item->getResultLabel();
        }, $result->getSubscaleResults()));

        $result->setCompletedAt(
            $this->userQuestionnaireService->getCompletedAtForUser(
                $userId,
                null,
                $this->questionnaireFlowService->getFlowByCategory($test->getCategory()->getId())
            )
        );

//        $response = $this->openAIClient->chat()->create(
//            [
//                'model'    => 'gpt-4',
//                'messages' => [
//                    [
//                        'role' => 'system', 'content' =>
//                        'This test is trying to provide an overview regarding:  ' . $test->getName() . ',
//                        Evaluate the test results as a whole and provide a summary of the results. Please note that the person reading this is a medical professional and thus is highly trained.'
//                    ],
//                    ['role' => 'user', 'content' => 'Here are the results: ' . $sanitizeResults],
//                ],
//            ]
//        );
//        $result->setDescription($response->choices[0]->message->content);

        return $this->downloadPDF($result);
    }

    private function downloadPDF(ReportTestResult $result): BinaryFileResponse
    {
        $path = $this->reportService->storeFile($result, Auth::id());

        return response()->download(storage_path("app/$path"), "report.pdf", [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
