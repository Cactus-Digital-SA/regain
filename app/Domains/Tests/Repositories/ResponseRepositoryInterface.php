<?php

namespace App\Domains\Tests\Repositories;

use App\Domains\Tests\Models\Response;
use App\Repositories\RepositoryInterface;

interface ResponseRepositoryInterface extends RepositoryInterface
{

    /**
     * @return Response[]|null
     */
    public function get(): ?array;
    /**
     * @param string $title
     * @param int $language_id
     * @return Response
     */
    public function findOrCreate(string $title, int $language_id): Response;
}
