<?php

namespace App\Domains\Questions\Import\Sheets;

use App\Domains\Subscales\Repositories\Eloquent\EloqSubscaleRepository;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use App\Domains\Subscales\Services\SubscaleService;
use App\Domains\Tests\Repositories\Eloquent\EloqTestRepository;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use App\Domains\Tests\Services\TestService;
use App\Domains\Thresholds\Models\Constants\ThresholdDisplayType;
use App\Domains\Thresholds\Models\Threshold;
use App\Domains\Thresholds\Models\ThresholdSubscaleLimit;
use App\Domains\Thresholds\Models\ThresholdTestLimit;
use App\Domains\Thresholds\Repositories\Eloquent\EloqThresholdRepository;
use App\Domains\Thresholds\Repositories\Eloquent\Models\Threshold as EloqThreshold;
use App\Domains\Thresholds\Services\ThresholdService;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ThresholdImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection): void
    {
        $thresholdService = new ThresholdService(new EloqThresholdRepository(new EloqThreshold()));
        $testService      = new TestService(new EloqTestRepository(new Test()));
        $subscaleService  = new SubscaleService(new EloqSubscaleRepository(new Subscale()));

        try {
            foreach ($collection as $row) {
                if ($row['test'] === null) {
                    continue;
                }

                $test = $testService->getByName($row['test']);

                if ($test) {
                    $rowAsArray         = $row->toArray();
                    $subscaleThresholds = array_filter($rowAsArray, static function ($value, $key) {
                        return str_starts_with($key, 'subscale_score') && !in_array($value, ["-", "", null], true);
                    }, ARRAY_FILTER_USE_BOTH);
                    $subscaleLabels     = array_filter($rowAsArray, static function ($value, $key) {
                        return str_starts_with($key, 'subscale_label') && !in_array($value, ["-", "", null], true);
                    }, ARRAY_FILTER_USE_BOTH);
                    $totalThresholds    = array_filter($rowAsArray, static function ($value, $key) {
                        return str_starts_with($key, 'total_score') && !in_array($value, ["-", "", null], true);
                    }, ARRAY_FILTER_USE_BOTH);
                    $totalLabels        = array_filter($rowAsArray, static function ($value, $key) {
                        return str_starts_with($key, 'total_label') && !in_array($value, ["-", "", null], true);
                    }, ARRAY_FILTER_USE_BOTH);

                    $notes = $row["notes"];

                    $subscaleLimits = [];
                    if ($row["subscale"] !== "-") {
                        $subscale = $subscaleService->getByName($row['subscale']);
                        if ($subscale) {
                            /** @var ThresholdSubscaleLimit[] $subscaleLimits */
                            $subscalesIndex = 0;
                            foreach ($subscaleThresholds as $subscaleThreshold) {
                                if ($subscaleThreshold !== "-") {
                                    $limits = explode("-", $subscaleThreshold);
                                    try {
                                        $subscaleLimit    = (new ThresholdSubscaleLimit())
                                            ->setLow((int)$limits[0])
                                            ->setSubscaleId($subscale->getId())
                                            ->setHigh((int)$limits[1])
                                            ->setLabel(array_values($subscaleLabels)[$subscalesIndex])
                                            ->setNotes($notes);
                                        $subscaleLimits[] = $subscaleLimit;
                                    } catch (Exception $e) {
                                        Log::error($e->getMessage());
                                    }
                                }
                                $subscalesIndex++;
                            }
                        }
                    }

                    $eloqThreshold = EloqThreshold::where("test_id", $test->getId())->get()->first();
                    $threshold     = new Threshold();
                    if ($eloqThreshold) {
                        $threshold = $thresholdService->getById($eloqThreshold->id);
                        if (count($subscaleLimits) > 0) {
                            $thresholdService->addSubscaleLimits($threshold, $subscaleLimits);
                        }
                    } else {
                        $questions = explode("-", $row["questions"]);

                        $threshold
                            ->setQuestionStart((int)$questions[0])
                            ->setQuestionEnd((int)$questions[1])
                            ->setDisplayType(
                                ThresholdDisplayType::from((int)$row["display_type"])
                            )->setTestId($test->getId());

                        if (in_array($threshold->getDisplayType(), [ThresholdDisplayType::SUBSCALE_SCORE, ThresholdDisplayType::TOTAL_SCORE], true)) {
                            /** @var ThresholdTestLimit[] $testLimits */
                            $testLimits      = [];
                            $testLimitsIndex = 0;
                            foreach ($totalThresholds as $totalThreshold) {
                                if ($totalThreshold !== "-") {
                                    $limits = explode("-", $totalThreshold);
                                    try {
                                        $testLimit = (new ThresholdTestLimit())
                                            ->setLow((int)$limits[0])
                                            ->setHigh((int)$limits[1])
                                            ->setNotes($notes);

                                        if (count($totalThresholds) === count($totalLabels)) {
                                            $testLimit->setLabel(array_values($totalLabels)[$testLimitsIndex]);
                                        } else {
                                            $testLimit->setLabel("");
                                        }

                                        $testLimits[] = $testLimit;
                                    } catch (Exception $e) {
                                        Log::error($e->getMessage());
                                    }
                                }
                                $testLimitsIndex++;
                            }
                            $threshold->setTestLimits($testLimits);
                        }

                        if (count($subscaleLimits) > 0) {
                            $threshold->addSubscaleLimits($subscaleLimits);
                        }
                        $thresholdService->store($threshold);
                    }
                }
            }
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }

    public function headingRow(): int
    {
        return 4;
    }
}
