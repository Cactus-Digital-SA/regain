<?php

namespace App\Domains\Reports\Http\Services;

use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\References\Services\ReferenceService;
use App\Domains\Reports\Constants\ReportTypes;
use App\Domains\Reports\Dtos\PatientReport\ReportTestResult;
use App\Domains\Reports\Http\Presenters\FlowPresenter;
use App\Domains\Reports\Http\Presenters\FlowsPresenter;
use App\Domains\Reports\Http\Presenters\TestPresenter;
use App\Domains\Reports\Repositories\Eloquent\Models\ReportFile;
use App\Domains\Scores\Repositories\Eloquent\UserTestScore;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use App\Domains\Thresholds\Services\ThresholdService;
use App\Domains\UserQuestionnaire\Services\UserQuestionnaireService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use JMS\Serializer\SerializerBuilder;
use Ramsey\Uuid\Uuid;

readonly class ReportService
{
    public function __construct(
        private UserQuestionnaireService $userQuestionnaireService,
        private ThresholdService $thresholdService,
        private ReferenceService $referenceService,
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
                    if (!$this->thresholdService->getThresholdByTest($test->id)) {
                        continue;
                    }

                    $testPresenter = new TestPresenter();

                    $completedAt = UserTestScore::where('user_id', $userId)
                                                ->where('test_id', $test->id)
                                                ->get("updated_at")->first()?->updated_at;

                    $testPresenter
                        ->setId($test->id)
                        ->setName($test->name)
                        ->setScientificReference($this->referenceService->getByTestId($test->id))
                        ->setCompletedAt($completedAt);

                    $flowPresenter->addTest($testPresenter);

                    $test = json_encode($testPresenter);
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

    public function storeFile(ReportTestResult $result, int $practitionerUserId, ?ReportTypes $reportType = ReportTypes::TEST): string
    {
        $uuid = Uuid::uuid4()->toString();

        ReportFile::create([
            "practitioner_user_id" => $practitionerUserId === 0 ? null : $practitionerUserId,
            "patient_user_id"      => $result->getPatientData()->getUserId(),
            "test_id"              => $result->getTest()->getId(),
            "uuid"                 => $uuid,
            "report_type"          => $reportType,
        ]);

        $filePath = "reports/{$uuid}.pdf";

        $pdf = PDF::loadView(
            $reportType === ReportTypes::TEST ?
                "reports.tests.index" :
                "reports.skills.index",
            ['result' => $result]);

        Storage::put($filePath, $pdf->output());

        return $filePath;
    }

    public function getFilePath(
        int $practitionerUserId,
        int $patientUserId,
        int $testId,
        ?ReportTypes $reportType = ReportTypes::TEST
    ): ?string {
        $file = ReportFile::where([
            "practitioner_user_id" => $practitionerUserId === 0 ? null : $practitionerUserId,
            "patient_user_id"      => $patientUserId,
            "test_id"              => $testId,
            "report_type"          => $reportType,
        ])->first();

        return $file ?
            "reports/" . $file->uuid . ".pdf" :
            null;
    }
}
