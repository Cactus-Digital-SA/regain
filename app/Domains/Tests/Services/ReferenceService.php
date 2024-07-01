<?php

namespace App\Domains\Tests\Services;

use App\Domains\Tests\Models\Reference;
use App\Domains\Tests\Repositories\ReferenceRepositoryInterface;

class ReferenceService
{

    private ReferenceRepositoryInterface $repository;

    /**
     * @param ReferenceRepositoryInterface $repository
     */
    public function __construct(ReferenceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Reference[]
     */
    public function get():array
    {
        return $this->repository->get();
    }

    /**
     * @param string $title
     * @param string $type
     * @param string $group
     * @return Reference
     */
    public function findOrCreate(string $title, string $type, string $group):Reference
    {
        return $this->repository->findOrCreate($title, $type, $group);
    }

    /**
     * @param string $group
     * @param string $type
     * @return Reference[]
     */
    public function getByGroupAndType(string $group, string $type):array
    {
        return $this->repository->getByGroupAndType($group, $type);
    }
}
