<?php

namespace App\Domains\Tests\Import\Sheets;

use App\Domains\Tests\Import\QuestionsImport;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SociodemographicImport implements ToCollection, WithHeadingRow
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
