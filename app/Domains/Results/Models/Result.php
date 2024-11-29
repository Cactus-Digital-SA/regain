<?php

namespace App\Domains\Results\Models;

use App\Models\CactusEntity;
use Nette\NotImplementedException;

class Result extends CactusEntity
{
    public function getValues(bool $withRelations = true): array
    {
        // TODO: Implement getValues() method.
        throw new NotImplementedException();
    }
}
