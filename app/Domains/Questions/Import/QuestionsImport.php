<?php

namespace App\Domains\Questions\Import;

use App\Domains\Categories\Repositories\Eloquent\Models\Category;
use App\Domains\Categories\Services\CategoryService;
use App\Domains\Instructions\Services\InstructionService;
use App\Domains\Language\Services\LanguageService;
use App\Domains\QuestionnaireFlow\Constants\QuestionnaireFlowType;
use App\Domains\Questions\Import\Sheets\PreAssessmentsImport;
use App\Domains\Questions\Import\Sheets\ReferenceImport;
use App\Domains\Questions\Import\Sheets\ScoresImport;
use App\Domains\Questions\Import\Sheets\SkillsImport;
use App\Domains\Questions\Import\Sheets\SociodemographicImport;
use App\Domains\Questions\Import\Sheets\ThresholdImport;
use App\Domains\Questions\Jobs\CreateQuestionFromJob;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\References\Services\ReferenceService;
use App\Domains\Responses\Services\ResponseService;
use App\Domains\Subscales\Services\SubscaleService;
use App\Domains\Tests\Services\TestService;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuestionsImport implements WithMultipleSheets
{
    /**
     * @param string $instruction
     * @param int    $language_id
     * @return int|null
     */
    public static function createInstruction(string $instruction, int $language_id): ?int
    {
        if ($instruction != null && $instruction !== '-') {
            /** @var InstructionService $instructionService */
            $instructionService = Container::getInstance()->get(InstructionService::class);

            return $instructionService->findOrCreateInstruction($instruction, $language_id)?->getId();
        }

        return null;
    }

    /**
     * @param string $code
     * @return int
     */
    public static function findLanguage(string $code): int
    {
        /** @var LanguageService $languageService */
        $languageService = Container::getInstance()->get(LanguageService::class);

        $language = $languageService->getByCode($code);

        if ($language->getCode() === null) {
            return 0;
        }

        return $language->getId();
    }

    /**
     * @param string $category
     * @return int
     * @throws Exception
     */
    public static function createCategory(string $category): int
    {
        try {
            $categoryService = Container::getInstance()->get(CategoryService::class);
            $category        = $categoryService->firstOrCreate($category, null, null);
            $categoryId      = $category->getId();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }

        return $categoryId;
    }

    /**
     * @param string $test
     * @param int    $categoryId
     * @return int
     * @throws Exception
     */
    public static function createTest(string $test, int $categoryId): int
    {
        try {
            $testService = Container::getInstance()->get(TestService::class);

            return $testService->findOrCreate($test, $categoryId, null)->getId();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @param string $subscale
     * @param int    $testId
     * @return int|null
     * @throws Exception
     */
    public static function createSubscale(string $subscale, int $testId): ?int
    {
        if ($subscale !== null && $subscale !== '-') {
            try {
                $subscaleService = Container::getInstance()->get(SubscaleService::class);

                return $subscaleService->findOrCreate($subscale, $testId, 2, null)->getId();
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                throw $exception;
            }
        }

        return null;
    }

    /**
     * @param array $responses
     * @param int   $language_id
     * @return array
     * @throws Exception
     */
    public static function createResponses(array $responses, int $language_id): array
    {
        try {
            $service      = Container::getInstance()->get(ResponseService::class);
            $responsesIds = [];

            foreach ($responses as $response) {
                $responsesIds[] = $service->findOrCreate($response['value'], $language_id, $response['type'], $response['sort'])->getId();
            }

            return $responsesIds;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @param Collection $collection
     * @return void
     * @throws Exception
     */
    public static function createQuestions(Collection $collection): void
    {
        $questionService = Container::getInstance()->get(QuestionsService::class);
        foreach ($collection as $row) {
            if ($row['unique_id'] == null) {
                continue;
            }

            $id              = (int)Helpers::extractIntegerFromString($row['unique_id']);
            $questionsExists = $questionService->getById($id);

            $referenceType  = (string)$row['reference_group'];
            $referenceGroup = (int)Helpers::extractIntegerFromString($row['reference']);

            /**  Get References */
            $referencesIds = QuestionsImport::getReferences($referenceType, $referenceGroup);

            if ($questionsExists) {
                $questionsExists->setReferences($referencesIds);
                $questionService->syncReferences($questionsExists, $questionsExists->getId());
                continue;
            }

            try {
                //Trying to create Question with job
                CreateQuestionFromJob::dispatch($row);
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e);
            }

            DB::commit();
        }

        // create flows
        $category = Category::where('name', '=', "SOCIO-DEMOGRAPHIC & WELLBEING")->first();
        if ($category) {
            $exists = DB::table('questionnaire_flows')->where([
                'category_id' => $category->id,
                'flow_type'   => QuestionnaireFlowType::PRE_ASSESSMENT
            ])->exists();

            if (!$exists) {
                DB::table('questionnaire_flows')->insert([
                    'category_id' => $category->id,
                    'flow_type'   => QuestionnaireFlowType::PRE_ASSESSMENT
                ]);
            }
        }

        $category = Category::where('name', '=', "PRE-ASSESSMENT")->first();
        if ($category) {
            $exists = DB::table('questionnaire_flows')->where([
                'category_id' => $category->id,
                'flow_type'   => QuestionnaireFlowType::PRE_ASSESSMENT
            ])->exists();

            if (!$exists) {
                DB::table('questionnaire_flows')->insert([
                    'category_id' => $category->id,
                    'flow_type'   => QuestionnaireFlowType::PRE_ASSESSMENT
                ]);
            }
        }

        $category = Category::where('name', '=', "SKILLS")->first();
        if ($category) {
            $exists = DB::table('questionnaire_flows')->where([
                'category_id' => $category->id,
                'flow_type'   => QuestionnaireFlowType::SKILLS
            ])->exists();

            if (!$exists) {
                DB::table('questionnaire_flows')->insert([
                    'category_id' => $category->id,
                    'flow_type'   => QuestionnaireFlowType::SKILLS
                ]);
            }
        }
    }

    /**
     * @param string $type
     * @param string $group
     * @return array
     */
    public static function getReferences(string $type, string $group): array
    {
        $referenceService = Container::getInstance()->get(ReferenceService::class);
        $references       = $referenceService->getByGroupAndType($group, $type);

        $referencesId = [];
        foreach ($references as $reference) {
            $referencesId[] = $reference->getId();
        }

        return $referencesId;
    }

    /**
     * @return string[]
     */
    public static function getMedications(): array
    {
        return [
            "Aptivus (Boehringer Ingelheim)",
            "Atripla (Bristol-Myers Squibb)",
            "Biktarvy (Gilead Sciences)",
            "Cabenuva (ViiV Healthcare - GSK, Pfizer, Janssen)",
            "Cimduo (Mylan)",
            "Combivir (ViiV Healthcare - GSK, Pfizer)",
            "Compera (Gilead Sciences)",
            "Delstrigo (Merck)",
            "Descovy (Gilead Sciences)",
            "Dovato (GSK)",
            "Edurant (ViiV Healthcare - GSK, Pfizer, Janssen)",
            "Emtriva (Gilead Sciences)",
            "Epivir (ViiV Healthcare - GSK, Pfizer)",
            "Epzicom (ViiV Healthcare - GSK, Pfizer)",
            "Eviplera (J&J, Janssen)",
            "Evotaz (Bristol-Myers Squibb)",
            "Fuzeon (Roche)",
            "Genvoya (Gilead Sciences)",
            "Intelence (Janssen)",
            "Isentress (Merck)",
            "Juluca (ViiV Healthcare - GSK, Pfizer)",
            "Kaletra (AbbVie Inc.)",
            "Kivexa (ViiV Healthcare - GSK, Pfizer)",
            "Lexiva (ViiV Healthcare - GSK, Pfizer)",
            "Norvir (AbbVie Inc.)",
            "Odefsey (Gilead Sciences)",
            "Pifeltro (Merck)",
            "Prezcobix (Janssen)",
            "Prezista (Janssen)",
            "Retrovir (ViiV Healthcare - GSK, Pfizer)",
            "Reyataz (Bristol-Myers Squibb)",
            "Rukobia (ViiV Healthcare - GSK, Pfizer)",
            "Selzentry (Pfizer)",
            "Stribild (Gilead Sciences)",
            "Sunlenca (Gilead Sciences)",
            "Sustiva (Bristol-Myers Squibb)",
            "Symfi (Viatris, Mylan)",
            "Symtuza (Janssen)",
            "Tivicay (ViiV Healthcare - GSK, Pfizer)",
            "Triumeq (ViiV Healthcare - GSK, Pfizer)",
            "Trizivir (ViiV Healthcare - GSK, Pfizer)",
            "Trogarzo (Theratechnologies)",
            "Truvada (Gilead Sciences)",
            "Tybost (Gilead Sciences)",
            "Viramune (Boehringer Ingelheim)",
            "Viread (Gilead Sciences)",
            "Vitekta (Gilead Sciences)",
            "Vocabria (ViiV Healthcare - GSK, Pfizer)",
            "Ziagen (ViiV Healthcare - GSK, Pfizer)"
        ];
    }

    public function sheets(): array
    {
        return [
            5 => new ReferenceImport(),
            0 => new SociodemographicImport(),
            1 => new PreAssessmentsImport(),
            2 => new SkillsImport(),
            3 => new ScoresImport(),
            4 => new ThresholdImport(),
        ];
    }
}
