<?php

namespace App\Domains\Questions\Import\Sheets;


use App\Domains\Questions\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Questions\Repositories\Eloquent\Models\Question as EloqQuestion;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\Responses\Repositories\Eloquent\EloqResponseRepository;
use App\Domains\Responses\Repositories\Eloquent\Models\Response as EloquentResponse;
use App\Domains\Responses\Services\ResponseService;
use App\Domains\Results\Repositories\Eloquent\EloqThresholdRepository;
use App\Domains\Results\Repositories\Eloquent\Models\Threshold;
use App\Domains\Results\Services\ThresholdService;
use App\Domains\Subscales\Repositories\Eloquent\EloqSubscaleRepository;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use App\Domains\Subscales\Services\SubscaleService;
use App\Domains\Tests\Repositories\Eloquent\EloqTestRepository;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use App\Domains\Tests\Services\TestService;
use App\Helpers\Helpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ThresholdImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection): void
    {
        $thresholdService = new ThresholdService(new EloqThresholdRepository(new Threshold()));
        $testService = new TestService(new EloqTestRepository(new Test()));
        $subscaleService = new SubscaleService(new EloqSubscaleRepository(new Subscale()));
        try {
            foreach ($collection as $row) {
                if ($row['test'] == null) continue;

                $test = $testService->getByName($row['test']);
                $subscale = $subscaleService->getByName($row['subscale']);

                if ($test) {
                    /**  Get Thresholds */

                    foreach ($row as $key => $value) {
                        if (str_contains($key, 'total_score') && $value != '-') {

                            $scoreNumber = Helpers::extractIntegerFromString($key);
                            $thresholds = explode('-', $value);

                            $thresholdDTO = new \App\Domains\Results\Models\Threshold();

                            $thresholdDTO->setTestId($test->getId());
                            $thresholdDTO->setRangeStart($thresholds[0]);
                            $thresholdDTO->setRangeEnd($thresholds[1]);
                            $thresholdDTO->setInterpretation($row['score_interpretation_'.$scoreNumber]);
                            $thresholdDTO->setSubscaleId($subscale?->getId());


                            //dd($thresholdDTO, $key, $value, $row['score_interpretation_'.$scoreNumber]);
                            $thresholdService->store($thresholdDTO);

                        }
                    }
                }
            }
        }catch (\Exception $exception) {
            Log::error($exception);
        }

    }

    public function headingRow(): int
    {
        return 4;
    }
}
