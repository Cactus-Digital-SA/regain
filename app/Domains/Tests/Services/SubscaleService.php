<?php

namespace App\Domains\Tests\Services;

use App\Domains\Tests\Models\Subscale;
use App\Domains\Tests\Repositories\SubscaleRepositoryInterface;

class SubscaleService
{
    private SubscaleRepositoryInterface $repository;

    /**
     * @param SubscaleRepositoryInterface $repository
     */
    public function __construct(SubscaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Subscale[]
     */
    public function get(): array
    {
        return $this->repository->get();
    }

    /**
     * @param string $name
     * @param int $test_id
     * @return Subscale
     */
    public function findOrCreate(string $name, int $test_id): Subscale
    {
        return $this->repository->findOrCreate($name, $test_id);
    }

}
