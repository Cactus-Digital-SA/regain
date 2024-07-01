<?php

use App\Domains\Tests\Http\Controllers\TestApiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/tests',
    'namespace' => 'tests.',
    'as' => 'tests.'],
    function () {
    Route::post('tests/paginated', [TestApiController::class, 'testsPaginated'])->name('testsPaginated');
    Route::post('categories/paginated', [TestApiController::class, 'categoriesPaginated'])->name('categoriesPaginated');

});
