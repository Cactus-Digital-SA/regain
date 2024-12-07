<?php

namespace App\Domains\Patient\Enums;

enum StatusEnum : string
{
    case INACTIVE = 'Inactive';
    case PROCESSING = 'Processing';
    case ALLOCATED = 'Allocated';

    public function label(): string
    {
        return match ($this) {
            self::INACTIVE => 'Inactive',
            self::PROCESSING => 'Processing',
            self::ALLOCATED => 'Allocated',
        };
    }

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

    public function model(): object
    {
        return (object)[
            'id' => $this->value,
            'name' => $this->label(),
        ];
    }

    // The names function can be inherited by all enums
    public static function names(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }

    // The array function can be inherited by all enums
    public static function array(): array
    {
        $allData = [];
        foreach (static::cases() as $case) {
            $allData[$case->value] = $case->label();
        }
        return $allData;
    }
}



