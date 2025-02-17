<?php

namespace App\Domains\References\Services;

use App\Domains\References\Models\Reference;
use App\Domains\References\Repositories\ReferenceRepositoryInterface;

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
    public function get(): array
    {
        return $this->repository->get();
    }

    /**
     * @param string      $title
     * @param string      $type
     * @param string      $group
     * @param string|null $link
     * @param string|null $groupName
     * @return Reference
     */
    public function findOrCreate(string $title, string $type, string $group, ?string $link, ?string $groupName): Reference
    {
        return $this->repository->findOrCreate($title, $type, $group, $link, $groupName);
    }

    /**
     * @param string $group
     * @param string $type
     * @return Reference[]
     */
    public function getByGroupAndType(string $group, string $type): array
    {
        return $this->repository->getByGroupAndType($group, $type);
    }

    /**
     * @param int $group
     * @return Reference[]
     */
    public function getByGroup(int $group): array
    {
        return $this->repository->getByGroup($group);
    }

    /**
     * @param int $testId
     * @return Reference[]
     */
    public function getByTestId(int $testId): array
    {
        return $this->repository->getByTestId($testId);
    }
}
