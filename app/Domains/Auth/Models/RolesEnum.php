<?php

namespace App\Domains\Auth\Models;

enum RolesEnum: int
{
    case SuperAdmin = 1;
    case Administrator = 2;
    case API = 3;
    case Tutor = 10;
    case Student = 11;


}
