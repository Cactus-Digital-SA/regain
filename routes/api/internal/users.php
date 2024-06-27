<?php


use App\Domains\Auth\Http\Controllers\User\UserApiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/users',
    'namespace' => 'users.',
    'as' => 'users.'
], function () {

    Route::post('emails/paginated', [UserApiController::class, 'emailsPaginated'])->name('emailsPaginated');

});
