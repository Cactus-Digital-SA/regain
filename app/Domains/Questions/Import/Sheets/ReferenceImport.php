<?php

namespace App\Domains\Questions\Import\Sheets;

use App\Domains\References\Repositories\Eloquent\EloqReferenceRepository;
use App\Domains\References\Repositories\Eloquent\Models\Reference as EloqReference;
use App\Domains\References\Services\ReferenceService;
use App\Helpers\Helpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ReferenceImport implements ToCollection, WithHeadingRow
{

    /**
     * @param Collection $collection
     * @return void
     */
    public function collection(Collection $collection): void
    {
        $referenceService = new ReferenceService(new EloqReferenceRepository(new EloqReference()));
        try {
            foreach ($collection as $row) {
                $group = (int)Helpers::extractIntegerFromString($row['group']);
                $reference = $row['reference'];
                $link = !empty($row['link']) ? $row['link'] : '' ;
                $name = !empty($row['name']) ? $row['name'] : '' ;

                $referenceService->findOrCreate($reference, 'Scientific Reference', $group,$link, $name);

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
