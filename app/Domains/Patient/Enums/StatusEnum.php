<?php

namespace App\Domains\Patient\Enums;

enum StatusEnum : int
{
    case INACTIVE = 1;
    case PROCESSING = 2;
    case ALLOCATED = 3;
    case WAITLIST_URGENT = 4;
    case WAITLIST = 5;
    case GUIDED = 6;

    public function label(): string
    {
        return match ($this) {
            self::INACTIVE => 'Inactive',
            self::PROCESSING => 'Processing',
            self::ALLOCATED => 'Allocated',
            self::WAITLIST_URGENT => 'Wishlist (Urgent)',
            self::WAITLIST => 'Wishlist',
            self::GUIDED => 'Guided',
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



