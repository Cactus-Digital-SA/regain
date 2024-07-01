<?php

namespace App\Providers;

use App\Domains\Auth\Repositories\Eloquent\EloqPermissionRepository;
use App\Domains\Auth\Repositories\Eloquent\EloqRoleRepository;
use App\Domains\Auth\Repositories\Eloquent\EloqUserRepository;
use App\Domains\Auth\Repositories\PermissionRepositoryInterface;
use App\Domains\Auth\Repositories\RoleRepositoryInterface;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Language\Repositories\Eloquent\EloqLanguageRepository;
use App\Domains\Language\Repositories\LanguageRepositoryInterface;
use App\Domains\Tests\Repositories\CategoryRepositoryInterface;
use App\Domains\Tests\Repositories\Eloquent\EloqCategoryRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqInstructionRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqSubscaleRepository;
use App\Domains\Tests\Repositories\Eloquent\EloqTestRepository;
use App\Domains\Tests\Repositories\InstructionRepositoryInterface;
use App\Domains\Tests\Repositories\QuestionRepositoryInterface;
use App\Domains\Tests\Repositories\SubscaleRepositoryInterface;
use App\Domains\Tests\Repositories\TestRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloqUserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, EloqRoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, EloqPermissionRepository::class);

        //Tests
        $this->app->bind(InstructionRepositoryInterface::class, EloqInstructionRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, EloqQuestionRepository::class);
        $this->app->bind(TestRepositoryInterface::class, EloqTestRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, EloqLanguageRepository::class);
        $this->app->bind(SubscaleRepositoryInterface::class, EloqSubscaleRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, EloqCategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
