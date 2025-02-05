<?php

namespace App\Domains\Practitioner\Enums;

enum PractitionerStatus: int
{
    case ACCEPTING = 1;
    case LIMITED   = 2;
    case FULL      = 3;

    public function label(): string
    {
        return __('practitioner.status.' . strtolower($this->name));
    }
}