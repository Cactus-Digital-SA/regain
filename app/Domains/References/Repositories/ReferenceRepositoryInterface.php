<?php

namespace App\Domains\References\Repositories;

use App\Domains\References\Models\Reference;
use App\Repositories\RepositoryInterface;

interface ReferenceRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Reference[]|null
     */
    public function get(): ?array;

    /**
     * @param string      $title
     * @param string      $type
     * @param string      $group
     * @param string|null $link
     * @param string|null $groupName
     * @return Reference
     */
    public function findOrCreate(string $title, string $type, string $group, ?string $link, ?string $groupName): Reference;

    /**
     * @param string $group
     * @param string $type
     * @return Reference[]
     */
    public function getByGroupAndType(string $group, string $type): array;

    /**
     * @param int $group
     * @return Reference[]
     */
    public function getByGroup(int $group): array;

    /**
     * @param int $testId
     * @return Reference[]
     */
    public function getByTestId(int $testId): array;
}
