<?php

namespace App\Domains\Tests\Import\Sheets;
use App\Domains\Language\Repositories\Eloquent\EloqLanguageRepository;
use App\Domains\Language\Services\LanguageService;
use App\Domains\Tests\Import\QuestionsImport;
use App\Domains\Tests\Models\Question;
use App\Domains\Tests\Repositories\Eloquent\EloqCategoryRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqInstructionRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqReferenceRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqResponseRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqSubscaleRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqTestRepository;
use App\Domains\Tests\Repositories\Eloquent\Models\Category;
use App\Domains\Tests\Repositories\Eloquent\Models\Reference;
use App\Domains\Tests\Repositories\Eloquent\Models\Response;
use App\Domains\Tests\Repositories\Eloquent\Models\Subscale;
use App\Domains\Tests\Repositories\Eloquent\Models\Test;
use App\Domains\Tests\Repositories\Eloquent\Models\Question as EloqQuestion;
use App\Domains\Tests\Services\CategoryService;
use App\Domains\Tests\Services\InstructionService;
use App\Domains\Tests\Services\QuestionsService;
use App\Domains\Tests\Services\ReferenceService;
use App\Domains\Tests\Services\ResponseService;
use App\Domains\Tests\Services\SubscaleService;
use App\Domains\Tests\Services\TestService;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PreAssessmentsImport implements ToCollection, WithHeadingRow
{

    /**
     * @param Collection $collection
     * @return void
     * @throws Exception
     */
    public function collection(Collection $collection): void
    {
        QuestionsImport::createQuestions($collection);
    }

    public function headingRow(): int
    {
        return 4;
    }


}
