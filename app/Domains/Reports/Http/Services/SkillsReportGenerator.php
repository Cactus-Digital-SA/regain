<?php

namespace App\Domains\Reports\Http\Services;

use App\Domains\Auth\Services\UserService;
use App\Domains\Patient\Services\PatientDataService;
use App\Domains\QuestionnaireFlow\QuestionnaireFlowService;
use App\Domains\Reports\Constants\ReportTypes;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResult;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResultSubscaleResult;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResultTotalResult;
use App\Domains\Reports\Dtos\PatientReport\ReportTrainingProgram;
use App\Domains\Tests\Services\TestService;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;
use App\Domains\Thresholds\Repositories\Eloquent\Models\Threshold;
use App\Domains\Thresholds\Services\ThresholdService;
use App\Domains\UserQuestionnaire\Services\UserQuestionnaireService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI\Client;

class SkillsReportGenerator
{
    public function __construct(
        private ThresholdService         $thresholdService,
        private TestService              $testService,
        private UserService              $userService,
        private PatientDataService       $patientDataService,
        private Client                   $openAIClient,
        private ReportService            $reportService,
        private UserQuestionnaireService $userQuestionnaireService,
        private QuestionnaireFlowService $questionnaireFlowService,
    )
    {
    }

    /**
     * @throws AuthorizationException
     * @throws \JsonException
     */
    public function generate(int $userId)
    {
        $testId = "21";
        $threshold = $this->thresholdService->getThresholdByTest($testId);

        if ($threshold === null) {
            throw new AuthorizationException("Threshold for test $testId not found.");
        }

        $filePath = $this->reportService->getFilePath($userId, $userId, $testId);
        if (($filePath !== null) && Storage::exists($filePath)) {
            return;
        }

        $test = $this->testService->getById($testId);

        $result = new ReportTestResult();

        $testThresholds = Threshold::where("test_id", $testId)
            ->with('testLimits')
            ->first()
            ?->testLimits()
            ->pluck('label')
            ->toArray();

        $test->setThresholds($testThresholds);
        $result->setTest($test);

        $totalScoreResult = DB::select("SELECT
            ROW_NUMBER() OVER (ORDER BY threshold_test_limits.low) AS row_index,
            threshold_test_limits.*,
            (SELECT score FROM user_test_scores WHERE user_id = ? AND test_id = ?) AS user_score
        FROM threshold_test_limits
        INNER JOIN thresholds ON thresholds.id = threshold_test_limits.threshold_id
        WHERE thresholds.test_id = ?
                 ", [$userId, $testId, $testId]);
        if (count($totalScoreResult) > 0) {
            $testResult = new ReportTestResultTotalResult();

            $found = false;
            foreach ($totalScoreResult as $scoreResult) {
                if ($scoreResult->user_score >= $scoreResult->low && $scoreResult->user_score <= $scoreResult->high) {
                    $testResult->setResultLabel($scoreResult->label)
                        ->setResultNotes($scoreResult->notes ?? "")
                        ->setScore($scoreResult->user_score ?? 0)
                        ->setTestIndex($scoreResult->row_index)
                        ->setTestItems(count($totalScoreResult))
                        ->setAlternatePrompt(false);
                    $found = true;
                }
            }

            if (!$found) {
                $testResult = (new ReportTestResultTotalResult())
                    ->setResultLabel("")
                    ->setResultNotes("")
                    ->setScore(0)
                    ->setTestIndex(0)
                    ->setTestItems(0)
                    ->setAlternatePrompt(true);
            }
        }
        $result->setTestResult($testResult);

        if ($threshold->getDisplayType() === ThresholdDisplayType::SUBSCALE_SCORE) {
            $subscales = $test->getSubscales();
            if (count($subscales) > 0) {
                $subscaleResults = [];
                foreach ($subscales as $subscale) {
                    $subscalesList = DB::select("
        SELECT
            ROW_NUMBER() OVER (ORDER BY threshold_subscale_limits.low) AS row_index,
            threshold_subscale_limits.*,
            (SELECT score FROM user_subscale_scores WHERE user_id = ? AND subscale_id = ?) AS user_score
        FROM threshold_subscale_limits
        INNER JOIN thresholds ON thresholds.id = threshold_subscale_limits.threshold_id
        WHERE thresholds.test_id = ? AND threshold_subscale_limits.subscale_id = ?",
                        [$userId, $subscale->getId(), $test->getId(), $subscale->getId()]);
                    $subscaleResult = new ReportTestResultSubscaleResult();
                    $result->setSubscaleItems(count($subscalesList));
                    $subscaleResult->setSubscaleName($subscale->getName());
                    foreach ($subscalesList as $subscaleListItem) {
                        if (
                            $subscaleListItem->user_score >= $subscaleListItem->low &&
                            $subscaleListItem->user_score <= $subscaleListItem->high
                        ) {
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


        $result->setUser($this->userService->getById($userId));
        $result->setPatientData($this->patientDataService->getByUserId($userId));

        $jsonResults = $this->formatResultsAsJson($result);

        $result->setCompletedAt(
            $this->userQuestionnaireService->getCompletedAtForUser(
                $userId,
                null,
                $this->questionnaireFlowService->getFlowByCategory($test->getCategory()->getId())
            )
        );

        $prompt = '
            You are a soft skills training expert. You will receive a JSON object containing the overall test result and
            results for each soft skill subscale. Your task is to generate training recommendations for each soft skill area.

            The input JSON will look like this:

            {
                "testResult": {
                    "result": "",
                    "test_name": "' . $test->getName() . '"
            },
            "subscaleResult": [
                {
                    "subscale_name": "Sample subscale 1",
                    "subscale_result": "Probability of sample subscale (low, medium, high)",
                },
                {
                    "subscale_name": "Sample subscale 2",
                    "subscale_result": "Probability of sample subscale (low, medium, high)",
                },
            ]
        }

        Your task:
            - Provide a "test_explanation" field: a short (3–4 sentence) professional summary based on the overall soft skills profile.
            - For each subscale with a result of "Low" or "Medium", provide one self-directed training program:
            - Total Duration: 56 hours
            - The training program should be presented as a structured schedule with one clearly defined activity per hour.
            - Activities must be:
                - Clear, instructional, and focused on self-practice
                - Realistic for individuals to follow without external help
                - Varied across the duration (e.g., reflection, journaling, practical tasks, analysis, challenges, role-play, reading)
                - The language must be formal, coaching-oriented, and professional.

        Output format:
        {
          "test_explanation": "",
          "subscales": [
            {
              "name": "Communication Skills",
              "explanation": "",
              "training_program": {
                "hours": 56,
                "description_per_hour": ["", "", "..."]
              }
            },
            {
              "name": "Empathy and Perspective-Taking",
              "explanation": "",
              "training_program": {
                "hours": 56,
                "description_per_hour": ["", "", "..."]
              }
            }
          ]
        }

        ❗Only generate training programs for subscales that are rated "Low" or "Medium". Skip subscales marked with "High" probability.

        ❗ Ensure the response only contains **properly formatted JSON** to allow for
         automated parsing and no other text before or after the opening and closing JSON object braces';

        $response = $this->openAIClient->chat()->create(
            [
                'model' => 'o3-mini-2025-01-31',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $prompt
                    ],
                    [
                        'role' => 'user',
                        'content' => 'Here is the json results: ' . $jsonResults],
                ],
            ]
        );

        $result->setDescription($response->choices[0]->message->content);

        $openAIResult = json_decode($response->choices[0]->message->content, true, 512, JSON_THROW_ON_ERROR);

        $explanation = mb_convert_encoding($openAIResult["test_explanation"], 'UTF-8', 'auto');
        $result->setDescription($explanation);

        foreach ($result->getSubscaleResults() as $subscaleResult) {
            $program = $this->getSubscaleTrainingProgram($openAIResult, trim($subscaleResult->getSubscaleName()));
            if (!array_key_exists("hours", $program)) {
                continue;
            }

            $description = $this->getSubscaleExplanation($openAIResult, trim($subscaleResult->getSubscaleName()));
            $subscaleResult->setDescription(mb_convert_encoding($description ?? "", 'UTF-8', 'auto'));

            $trainingProgram = new ReportTrainingProgram();
            $trainingProgram->setHours($program["hours"]);
            $trainingProgram->setHourlyTask($program["description_per_hour"]);
            $subscaleResult->setTrainingProgram($trainingProgram);
        }

        $this->reportService->storeFile($result, 0, ReportTypes::SKILL);
    }

    private function getSubscaleExplanation(array $openAIResult, string $searchName): ?string
    {
        foreach ($openAIResult["subscales"] as $subscale) {
            if (isset($subscale['name']) && $subscale['name'] === $searchName) {
                return $subscale['explanation'] ?? 'No description available';
            }
        }

        return null; // Return null if the subscale is not found
    }

    private function getSubscaleTrainingProgram(array $openAIResult, string $searchName): array
    {
        foreach ($openAIResult["subscales"] as $subscale) {
            if (isset($subscale['name']) && $subscale['name'] === $searchName) {
                return $subscale['training_program'] ?? [];
            }
        }

        return []; // Return null if the subscale is not found
    }

    /**
     * @throws \JsonException
     */
    private function formatResultsAsJson(ReportTestResult $result): string
    {
        $data = [];
        $data["testResult"] = [];
        $data["testResult"]["result"] = $result->getTestResult()?->getResultLabel();
        $data["testResult"]["test_name"] = $result->getTest()?->getName();
        $data["testResult"]["short_description"] = "";

        $data["subscaleResult"] = [];
        foreach ($result->getSubscaleResults() as $subscaleResult) {
            $subscaleData = [];
            $subscaleData["subscale_name"] = trim($subscaleResult->getSubscaleName());
            $subscaleData["subscale_result"] = trim($subscaleResult->getResultLabel());
            $subscaleData["short_description"] = "";
            $data["subscaleResult"][] = $subscaleData;
        }

        return json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
