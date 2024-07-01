<?php

namespace App\Domains\Tests\Repositories;

use App\Domains\Tests\Models\Reference;
use App\Repositories\RepositoryInterface;

interface ReferenceRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Reference[]|null
     */
    public function get(): ?array;

    public function findOrCreate(string $title, string $type, string $group): Reference;

    /**
     * @param string $group
     * @param string $type
     * @return Reference[]
     */
    public function getByGroupAndType(string $group, string $type): array;
}
