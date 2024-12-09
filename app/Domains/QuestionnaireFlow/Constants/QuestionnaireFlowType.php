<?php

declare(strict_types = 1);

namespace App\Domains\QuestionnaireFlow\Constants;

enum QuestionnaireFlowType: int
{
    case PRE_ASSESSMENT  = 1;
    case SKILLS          = 2;
    case MEDICAL_HISTORY = 3;
}
