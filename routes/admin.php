<?php

use App\Domains\Auth\Http\Controllers\DataTable\DataTableController;
use App\Domains\Auth\Http\Controllers\Role\RoleController;
use App\Domains\Auth\Http\Controllers\User\UserApiController;
use App\Domains\Auth\Http\Controllers\User\UserController;
use App\Domains\Dashboard\Http\Controllers\Backend\DashboardController;
use App\Domains\Instructions\Http\Controllers\InstructionController;
use App\Domains\Questions\Http\Controllers\Datatable\DatatableController as QuestionsDatatableController;
use App\Domains\Questions\Http\Controllers\Import\ImportController;
use App\Domains\Questions\Http\Controllers\QuestionController;
use App\Domains\Settings\Http\Controllers\AppSettingsController;
use App\Domains\Tests\Http\Controllers\TestApiController;
use App\Domains\Tests\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::group([]
    , function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        //Route::get('home', [DashboardController::class, 'index'])->name('home');

        Route::group([
            'prefix'     => 'settings',
            'middleware' => 'role:Administrator',
        ], function () {
            Route::get('clear/{setting}', [AppSettingsController::class, 'clear_settings'])->name('clear-settings');
            Route::get('cache/{setting}', [AppSettingsController::class, 'cache_settings'])->name('cache-settings');

            Route::get('optimize-app', [AppSettingsController::class, 'optimize_app'])->name('optimize-app');
            Route::get('optimize-clear', [AppSettingsController::class, 'optimize_clear'])->name('optimize-clear');

            Route::get('app-settings', [AppSettingsController::class, 'index'])->name('setting.index');
        });

        Route::group([
            'prefix' => 'users',
            'as'     => 'users.',
            //    'middleware' => 'permission:crud roles',
        ], function () {
            Route::get('/', [UserController::class, 'index'])->name('index')->middleware('role_or_permission:admin.access.user.list');
            Route::post('/', [UserController::class, 'store'])->name('store')->middleware('role_or_permission:admin.access.user.create');
            Route::get('/create', [UserController::class, 'create'])->name('create')->middleware('role_or_permission:admin.access.user.create');

            Route::delete('/{userId}', [UserController::class, 'delete'])->name('delete')->middleware('role_or_permission:admin.access.user.delete');

            Route::get('/{userId}/edit', [UserController::class, 'edit'])->name('edit');
            Route::patch('/{userId}/', [UserController::class, 'update'])->name('update');

            Route::get('/{userId}/password/change', [UserController::class, 'editPassword'])
                 ->name('change-password');

            Route::patch('/{userId}/password/change', [UserController::class, 'updatePassword'])
                 ->name('change-password.update');

            Route::get('/deleted', [UserController::class, 'deleted'])->name('deleted')->middleware('role_or_permission:admin.access.user');
            Route::get('/deactivated', [UserController::class, 'deactivated'])->name('deactivated')->middleware('role_or_permission:admin.access.user');
            Route::post('/restore', [UserController::class, 'restore'])->name('restore')->middleware('role_or_permission:admin.access.user');
            Route::get('/{userId}', [UserController::class, 'show'])->name('show')->middleware('role_or_permission:admin.access.user');

            Route::post('emails/paginated', [UserApiController::class, 'emailsPaginated'])->name('emailsPaginated');
        });

        Route::patch('user/{userId}/mark/{status}', [UserController::class, 'updateActive'])->name('users.mark')
             ->where(['status' => '[0,1]'])
             ->middleware('role_or_permission:admin.access.user.edit');

        //Roles
        Route::group([
            'prefix'     => 'roles',
            'as'         => 'roles.',
            'middleware' => 'permission:crud roles',
        ], function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::get('/{roleId}', [RoleController::class, 'show'])->name('show');
            Route::get('/{roleId}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::patch('/{roleId}', [RoleController::class, 'update'])->name('update');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::delete('/{roleId}', [RoleController::class, 'delete'])->name('delete');
        });

        Route::controller(DataTableController::class)->prefix('datatable')->name('datatable.')->group(function () {
            Route::get('/roles', 'roles')->name('roles')->middleware('permission:crud roles');
            Route::get('/logs', 'logs')->name('logs')->middleware('permission:view logs');
            Route::post('/users', 'users')->name('users');
        });

        Route::prefix('tests')->name('tests.')->group(function () {
            Route::prefix('questions')->name('questions.')->group(function () {
                Route::get('/', [QuestionController::class, 'index'])->name('index')->middleware('permission:admin.tests.view');
                Route::get('create', [QuestionController::class, 'create'])->name('create')->middleware('permission:admin.tests.create');
                Route::post('store', [QuestionController::class, 'store'])->name('store')->middleware('permission:admin.tests.create');
            });

            Route::prefix('instructions')->name('instructions.')->group(function () {
                Route::get('/', [InstructionController::class, 'index'])->name('index')->middleware('permission:admin.instructions.view');
                Route::get('create', [InstructionController::class, 'create'])->name('create')->middleware('permission:admin.instructions.create');
                Route::post('store', [InstructionController::class, 'store'])->name('store')->middleware('permission:admin.instructions.create');
            });

            Route::get('create', [TestController::class, 'create'])->name('create');

            Route::post('tests/paginated', [TestApiController::class, 'testsPaginated'])->name('testsPaginated');
            Route::post('categories/paginated', [TestApiController::class, 'categoriesPaginated'])->name('categoriesPaginated');
        });

        Route::controller(QuestionsDatatableController::class)->prefix('datatable')->name('tests.datatable.')->group(function () {
            Route::post('/questions', 'questions')->name('questions')->middleware('permission:admin.tests.view');
            Route::post('/instructions', 'instructions')->name('instructions')->middleware('permission:admin.instructions.view');
        });

        Route::controller(ImportController::class)->prefix('import')->name('tests.import.')->group(function () {
            Route::post('/questions', 'questions')->name('questions')->middleware('permission:admin.tests.create');
            Route::post('/history-questions', 'medicalHistoryQuestions')->name('medicalHistoryQuestions')->middleware('permission:admin.tests.create');
        });
    });


