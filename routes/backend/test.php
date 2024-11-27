<?php

use App\Domains\Instructions\Http\Controllers\InstructionController;
use App\Domains\Questions\Http\Controllers\Datatable\DatatableController;
use App\Domains\Questions\Http\Controllers\Import\ImportController;
use App\Domains\Questions\Http\Controllers\QuestionController;
use App\Domains\Tests\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;


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
    Route::get('create' , [TestController::class, 'create'])->name('create');
});


Route::controller(DatatableController::class)->prefix('datatable')->name('tests.datatable.')->group(function () {
    Route::post('/questions', 'questions')->name('questions')->middleware('permission:admin.tests.view');
    Route::post('/instructions', 'instructions')->name('instructions')->middleware('permission:admin.instructions.view');
});

Route::controller(ImportController::class)->prefix('import')->name('tests.import.')->group(function () {
    Route::post('/questions', 'questions')->name('questions')->middleware('permission:admin.tests.create');
});

