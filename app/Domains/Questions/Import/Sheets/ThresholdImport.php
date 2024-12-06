<?php

namespace App\Domains\Questions\Import\Sheets;

use App\Domains\Subscales\Repositories\Eloquent\EloqSubscaleRepository;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use App\Domains\Subscales\Services\SubscaleService;
use App\Domains\Tests\Repositories\Eloquent\EloqTestRepository;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use App\Domains\Tests\Services\TestService;
use App\Domains\Thresholds\Repositories\Eloquent\EloqThresholdRepository;
use App\Domains\Thresholds\Repositories\Eloquent\Models\Threshold as EloqThreshold;
use App\Domains\Thresholds\Services\ThresholdService;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ThresholdImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection): void
    {
        $thresholdService = Container::getInstance()->get(ThresholdService::class);
        $testService      = Container::getInstance()->get(TestService::class);
        $subscaleService  = Container::getInstance()->get(SubscaleService::class);

        try {
            foreach ($collection as $row) {
                if ($row['test'] == null) {
                    continue;
                }

                $test     = $testService->getByName($row['test']);
                $subscale = $subscaleService->getByName($row['subscale']);

                if ($test) {
                    $rowAsArray         = $row->toArray();
                    $subscaleThresholds = array_filter($rowAsArray, function ($key) {
                        return strpos($key, 'subscale_score') === 0; // Check if the key starts with 'subscale_score'
                    }, ARRAY_FILTER_USE_KEY);
                    $subscaleLabels     = array_filter($rowAsArray, function ($key) {
                        return strpos($key, 'subscale_label') === 0; // Check if the key starts with 'subscale_score'
                    }, ARRAY_FILTER_USE_KEY);
                    $totalThresholds    = array_filter($rowAsArray, function ($key) {
                        return strpos($key, 'total_score') === 0; // Check if the key starts with 'subscale_score'
                    }, ARRAY_FILTER_USE_KEY);
                    $totalLabels        = array_filter($rowAsArray, function ($key) {
                        return strpos($key, 'total_label') === 0; // Check if the key starts with 'subscale_score'
                    }, ARRAY_FILTER_USE_KEY);

                    $notes = $row["notes"];
                    $test  = 1;

//
//                    foreach ($row as $key => $value) {
//                        if (str_contains($key, 'total_score') && $value != '-') {
//
//                            $scoreNumber = Helpers::extractIntegerFromString($key);
//                            $thresholds = explode('-', $value);
//
//                            $thresholdDTO = new \App\Domains\Results\Models\Threshold();
//
//                            $thresholdDTO->setTestId($test->getId());
//                            $thresholdDTO->setRangeStart($thresholds[0]);
//                            $thresholdDTO->setRangeEnd($thresholds[1]);
//                            $thresholdDTO->setInterpretation($row['score_interpretation_'.$scoreNumber]);
//                            $thresholdDTO->setSubscaleId($subscale?->getId());
//
//
//                            //dd($thresholdDTO, $key, $value, $row['score_interpretation_'.$scoreNumber]);
//                            $thresholdService->store($thresholdDTO);
//
//                        }
//                    }
                }
            }
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }

    public function headingRow(): int
    {
        return 4;
    }
}
