<?php

declare(strict_types = 1);

namespace App\Domains\QuestionnaireFlow\Constants;

enum QuestionnaireFlowType: int
{
    case SOCIODEMOGRAPHIC_ASSESSMENT = 1;
    case SKILLS                      = 2;
}
