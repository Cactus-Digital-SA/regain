<?php

namespace App\Domains\Questions\Import\Sheets;

use App\Domains\References\Repositories\Eloquent\EloqReferenceRepository;
use App\Domains\References\Repositories\Eloquent\Models\Reference as EloqReference;
use App\Domains\References\Services\ReferenceService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MedicalHistoryReferenceImport implements ToCollection, WithHeadingRow
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
                $reference = $row['selection_ref_6'];
                if (!$reference) {
                    continue;
                }

                $referenceService->findOrCreate($reference, 'Medical History Reference', "Medical History Reference", null, null);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function headingRow(): int
    {
        return 4;
    }
}
