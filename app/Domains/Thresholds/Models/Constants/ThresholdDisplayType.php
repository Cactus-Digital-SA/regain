<?php

namespace App\Domains\Thresholds\Models\Constants;

enum ThresholdDisplayType: int
{
    case DISPLAY        = 1;
    case TOTAL_SCORE    = 2;
    case SUBSCALE_SCORE = 3;
}