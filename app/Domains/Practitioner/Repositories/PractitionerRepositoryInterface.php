<?php

namespace App\Domains\Practitioner\Repositories;

use App\Domains\Practitioner\Model\Practitioner;
use App\Repositories\RepositoryInterface;

interface PractitionerRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     * @return ?Practitioner
     */
    public function getById(string $id): ?Practitioner;
}
