<?php

namespace App\Domains\Questions\Import;

use App\Domains\Categories\Repositories\Eloquent\EloqCategoryRepository;
use App\Domains\Categories\Repositories\Eloquent\Models\Category;
use App\Domains\Categories\Services\CategoryService;
use App\Domains\Instructions\Repositories\Eloquent\EloqInstructionRepository;
use App\Domains\Instructions\Repositories\Eloquent\Models\Instruction;
use App\Domains\Instructions\Services\InstructionService;
use App\Domains\Language\Repositories\Eloquent\EloqLanguageRepository;
use App\Domains\Language\Repositories\Eloquent\Models\Language;
use App\Domains\Language\Services\LanguageService;
use App\Domains\Questions\Import\Sheets\PreAssessmentsImport;
use App\Domains\Questions\Import\Sheets\ReferenceImport;
use App\Domains\Questions\Import\Sheets\ScoresImport;
use App\Domains\Questions\Import\Sheets\SkillsImport;
use App\Domains\Questions\Import\Sheets\SociodemographicImport;
use App\Domains\Questions\Import\Sheets\ThresholdImport;
use App\Domains\Questions\Jobs\CreateQuestionFromJob;
use App\Domains\Questions\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Questions\Repositories\Eloquent\Models\Question as EloqQuestion;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\References\Repositories\Eloquent\EloqReferenceRepository;
use App\Domains\References\Repositories\Eloquent\Models\Reference;
use App\Domains\References\Services\ReferenceService;
use App\Domains\Responses\Repositories\Eloquent\EloqResponseRepository;
use App\Domains\Responses\Repositories\Eloquent\Models\Response;
use App\Domains\Responses\Services\ResponseService;
use App\Domains\Subscales\Repositories\Eloquent\EloqSubscaleRepository;
use App\Domains\Subscales\Repositories\Eloquent\Models\Subscale;
use App\Domains\Subscales\Services\SubscaleService;
use App\Domains\Tests\Repositories\Eloquent\EloqTestRepository;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use App\Domains\Tests\Services\TestService;
use App\Helpers\Helpers;
use Exception;
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
        if ($instruction != null && $instruction != '-') {
            $repository         = new EloqInstructionRepository(new Instruction());
            $instructionService = new InstructionService($repository);

            $instructionDTO = $instructionService->findOrCreateInstruction($instruction, $language_id);

            return $instructionDTO->getId();
        }

        return null;
    }

    /**
     * @param string $code
     * @return int
     */
    public static function findLanguage(string $code): int
    {
        $repository      = new EloqLanguageRepository(new Language());
        $languageService = new LanguageService($repository);

        $language = $languageService->getByCode($code);

        if ($language->getCode() == null) {
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
            $categoryService = new CategoryService(new EloqCategoryRepository(new Category()));
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
            $testService = new TestService(new EloqTestRepository(new Test()));
            $testDTO     = $testService->findOrCreate($test, $categoryId, null);

            return $testDTO->getId();
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
        if ($subscale != null && $subscale != '-') {
            try {
                $subscaleService = new SubscaleService(new EloqSubscaleRepository(new Subscale()));
                $subscaleDTO     = $subscaleService->findOrCreate($subscale, $testId, 2, null);

                return $subscaleDTO->getId();
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
            $service      = new ResponseService(new EloqResponseRepository(new Response()));
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
        $questionService = new QuestionsService(new EloqQuestionRepository(new EloqQuestion()));
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
    }

    /**
     * @param string $type
     * @param string $group
     * @return array
     */
    public static function getReferences(string $type, string $group): array
    {
        $referenceService = new ReferenceService(new EloqReferenceRepository(new Reference()));
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
            3 => new ScoresImport(),
            4 => new ThresholdImport(),
            1 => new PreAssessmentsImport(),
            2 => new SkillsImport(),
        ];
    }
}
