<?php

namespace App\Domains\Practitioner\Repositories;

use App\Domains\Practitioner\Models\Practitioner;
use App\Repositories\RepositoryInterface;

interface PractitionerRepositoryInterface extends RepositoryInterface
{
    public function getById(string $id): ?Practitioner;

    public function getByUserId(string $userId): ?Practitioner;
}
