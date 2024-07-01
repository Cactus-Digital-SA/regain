<?php

namespace App\Domains\Tests\Import\Sheets;

use App\Domains\Tests\Repositories\Eloquent\EloqReferenceRepository;
use App\Domains\Tests\Repositories\Eloquent\Models\Reference as EloqReference;
use App\Domains\Tests\Services\ReferenceService;
use App\Helpers\Helpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ReferenceImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection): void
    {
        $referenceService = new ReferenceService(new EloqReferenceRepository(new EloqReference()));
        try {
            foreach ($collection as $row) {
                /**  Get Responses */
                $references = [];

                foreach ($row as $key => $value) {
                    if (str_contains($key, 'scientific_ref_group') && !empty($value)) {
                        $group = (int)Helpers::extractIntegerFromString($key);
                        $references[$group] = (string)$value;
                    }
                }
                foreach ($references as $group => $reference) {
                    $referenceService->findOrCreate($reference, 'Scientific Reference', $group);
                }
            }
        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

    }

    public function headingRow(): int
    {
        return 4;
    }
}
