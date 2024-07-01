<?php

namespace App\Domains\Language\Repositories;

use App\Domains\Language\Models\Language;
use App\Repositories\RepositoryInterface;

interface LanguageRepositoryInterface extends RepositoryInterface
{
    public function getByCode(string $code): ?Language;

    public function get(): ?array;


}
