<?php

namespace App\Domains\Responses\Enums;

enum TypeEnum: int
{
    case BASIC       = 1;
    case MEDICATION  = 2;
    case PROFESSIONS = 3;

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
