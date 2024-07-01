<?php

namespace App\Domains\Tests\Services;

use App\Domains\Tests\Models\Response;
use App\Domains\Tests\Repositories\ResponseRepositoryInterface;

class ResponseService
{
    private ResponseRepositoryInterface $repository;

    /**
     * @param ResponseRepositoryInterface $repository
     */
    public function __construct(ResponseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param string $title
     * @param int $language_id
     * @return Response
     */
    public function findOrCreate(string $title, int $language_id): Response
    {
        return $this->repository->findOrCreate($title, $language_id);
    }
}
