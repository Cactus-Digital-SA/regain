<?php

namespace App\Domains\Patient\Enums;

enum StatusEnum : string
{
    case INACTIVE = 'Inactive';
    case PROCESSING = 'Processing';
    case ALLOCATED = 'Allocated';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return string
     */
    public function getLabelClass() : string {
        return match($this) {
            StatusEnum::INACTIVE => 'bg-label-grey',
            StatusEnum::PROCESSING => 'bg-label-secondary',
            StatusEnum::ALLOCATED => 'bg-label-success',
        };
    }
}



