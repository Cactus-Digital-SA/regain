<?php

use App\Domains\Auth\CustomLoginController;
use App\Domains\Patient\Http\Controllers\PatientController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', [HomeController::class, 'index'])->name('home');

//Route::get('/', function () {
//    return view('welcome');
//});

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

/*
 * Backend Routes
 *
 * These routes can only be accessed by users with type `admin`
 */

Route::group([
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => ['auth']
], function () {
    require_once(__DIR__ . '/admin.php');
});

Route::group([
    'prefix'     => '',
    'as'         => 'patient.',
    'middleware' => ['role.patient', 'auth'],
], function () {
    Route::get('/', [PatientController::class, 'index'])->name('home');
    Route::post('/submit-answer', [PatientController::class, 'submitAnswer'])->name('submit-answer');
    Route::post('/submit-answers', [PatientController::class, 'submitAnswers'])->name('submit-answers');
});

Route::group([
    'prefix'     => '',
    'as'         => 'regain.',
    'middleware' => ['role.administrator', 'auth'],
], function () {

    Route::resource('/patients', \App\Domains\Regain\Http\PatientController::class);
    Route::post('patients/table', [\App\Domains\Regain\Http\PatientController::class, 'datatable'])->name('patients.datatable');
});


////2fa fortify
//Route::post('/2fa-confirm', [TwoFactorAuthController::class, 'confirm'])->name('fortify.two-factor.confirm');
//
//Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
//    if (Features::enabled(Features::twoFactorAuthentication())) {
//        if (config('fortify.views', true)) {
//            Route::get('/recovery-pass', [TwoFactorAuthController::class, 'recoveryPass'])
//                 ->middleware(['guest:' . config('fortify.guard')])
//                 ->name('two-factor.recovery_pass');
//
//            Route::post('/send-email', [TwoFactorAuthController::class, 'sendEmail'])
//                 ->middleware(['guest:' . config('fortify.guard')])
//                 ->name('two-factor.send_email');
//        }
//    }
//});

// LoggedIn User Profile - Update
//Route::group([
//    'prefix'     => 'profile',
//    'as'         => 'profile.',
//    'middleware' => ['auth'],
//], function () {
//    Route::get('/', [ProfileController::class, 'show'])->name('show');
//    Route::patch('/{user}/delete-photo', [ProfileController::class, 'delete_profile_photo'])->name('delete_profile_photo');
//
//    Route::get('/{userId}/edit', [ProfileController::class, 'edit'])->name('edit');
//    Route::patch('/{userId}/', [ProfileController::class, 'update'])->name('update');
//
//    Route::get('/{userId}/password/change', [ProfileController::class, 'editPassword'])
//         ->name('change-password');
//
//    Route::patch('/{userId}/password/change', [ProfileController::class, 'updatePassword'])
//         ->name('change-password.update');
//});

// TODO, REMOVE WHEN DONE
// For mock purposes

Route::group([
    'prefix' => 'mock',
    'as'     => 'mock.',
], function () {
    Route::get('/date-of-birth', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showDateOfBirth'])->name('date-of-birth');
    Route::get('/current-location', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showCurrentLocation'])->name('current-location');
    Route::get('/disability-disorder', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showDisabilityDisorder'])->name('disability-disorder');
});
