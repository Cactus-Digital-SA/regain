<?php

namespace App\Domains\Patient\Enums;

enum MilitaryStatusEnum : int
{
    case ACTIVE = 1;
    case RESERVE = 2;
    case VETERAN = 3;
    case PERSONNEL = 4;
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::RESERVE => 'Reserve',
            self::VETERAN => 'Veteran',
            self::PERSONNEL => 'Personnel',
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



