<?php

use App\Domains\Auth\CustomLoginController;
use App\Domains\Patient\Http\Controllers\PatientController;
use App\Domains\Practitioner\Http\Controllers\PractitionerController;
use App\Domains\Regain\Http\Controllers\PatientController as RegainPatientController;
use App\Domains\Reports\Http\Controllers\ReportsController;
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
    'middleware' => ['role.super-admin', 'auth']
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
    'prefix'     => 'practitioner',
    'as'         => 'practitioner.',
    'middleware' => ['role.practitioner', 'auth'],
], function () {
    Route::get('/', [PractitionerController::class, 'index'])->name('home');
    Route::get('/patients', [PractitionerController::class, 'patients'])->name('patients');
    Route::get('/patients/table', [PractitionerController::class, 'datatable'])->name('datatable');
    Route::get('/patients/{userId}', [PractitionerController::class, 'patient'])->name('patient');
    Route::post('/patients/medical-history/{userId}', [PractitionerController::class, 'getMedicalHistoryQuestions'])->name('medical-history');
    Route::get('/patients/report/{userId}/{testId}', [ReportsController::class, 'testReport'])->name('test-report');
    Route::post('/patients/medical-history/{userId}/submit', [PractitionerController::class, 'submitMedicalHistoryQuestions'])->name('medical-history-submit');
    Route::get('/patients/medical-history/{userId}/report', [PractitionerController::class, 'getMedicalHistoryReport'])->name('medical-history-report');
    Route::get('/patients/medical-history/{userId}/report/download', [PractitionerController::class, 'downloadMedicalHistoryReport'])->name('medical-history-report-download');
});

Route::group([
    'prefix'     => 'organization',
    'as'         => 'organization.',
    'middleware' => ['role.administrator', 'auth'],
], function () {

    Route::get('/', [RegainPatientController::class, 'patients'])->name('home');
    Route::get('/patients', [RegainPatientController::class, 'patients'])->name('patients');
    Route::post('/patients/store', [RegainPatientController::class, 'storePatient'])->name('patients.create');
    Route::get('/patients/destroy', [RegainPatientController::class, 'patientsDestroy'])->name('patients.destroy');
    Route::post('/patients/table', [RegainPatientController::class, 'patientsDatatable'])->name('patients.datatable');
    Route::post('/patients/create-page/{page}', [RegainPatientController::class, 'createPatientPage'])->name('patients.create-page');
    Route::get('/practitioners', [RegainPatientController::class, 'practitioners'])->name('practitioners');
    Route::post('/practitioners/table', [RegainPatientController::class, 'practitionersDatatable'])->name('practitioners.datatable');
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
    Route::post('patients/table', [RegainPatientController::class, 'patientsDatatable'])->name('patients.datatable'); //remove when done
    Route::get('/date-of-birth', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showDateOfBirth'])->name('date-of-birth');
    Route::get('/current-location', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showCurrentLocation'])->name('current-location');
    Route::get('/disability-disorder', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showDisabilityDisorder'])->name('disability-disorder');

    //Login flow Front
    Route::get('flow/login', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showFlowLogin'])->name('login-flow');
    Route::get('flow/info', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showFlowInfo'])->name('info-flow');
    Route::get('flow/welcome-back', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showFlowWelcomeBack'])->name('welcome-back-flow');


//    Dashboards
    Route::get('organization/dashboard', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showOrganizationDashboard'])->name('organization-dashboard');
    Route::get('practitioner/dashboard', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showPractitionerDashboard'])->name('practitioner-dashboard');
    Route::get('practitioner/dashboard/calendar', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showPractitionerCalendarDashboard'])->name('practitioner-dashboard');
    Route::get('practitioner/dashboard/export-pdf/three', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'previewThreeBarReport']);
    Route::get('practitioner/dashboard/export-pdf/four', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'previewFourBarReport']);
    Route::get('dashboard/login', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showLoginDashboard'])->name('login-dashboard');
    Route::get('email', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showEmail'])->name('login-dashboard');

});
