<?php

use App\Domains\Auth\CustomLoginController;
use App\Domains\Patient\Http\Controllers\PatientController;
use App\Domains\Practitioner\Http\Controllers\PractitionerController;
use App\Domains\Regain\Http\Controllers\PatientController as RegainPatientController;
use App\Domains\Reports\Http\Controllers\ReportsController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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
    Route::get('/', [PatientController::class, 'index'])->name('index');
    Route::get('/help-center', function () {
        return view('patient.help-center');
    })->name('help-center');
    Route::get('/community', function () {
        return view("patient.community");
    })->name('community');
    Route::get('/regain-info', function () {
        return view("patient.regain-info");
    })->name('regain-info');
    Route::post('/submit-answer', [PatientController::class, 'submitAnswer'])->name('submit-answer');
    Route::post('/submit-answers', [PatientController::class, 'submitAnswers'])->name('submit-answers');


    Route::get('/home' , [PatientController::class, 'showWelcomeToRegain'])->name('home');
});

Route::group([
    'prefix'     => 'practitioner',
    'as'         => 'practitioner.',
    'middleware' => ['role.practitioner', 'auth'],
], function () {
    Route::get('/', [PractitionerController::class, 'patients'])->name('home');
    Route::get('/patients', [PractitionerController::class, 'patients'])->name('patients');
    Route::any('/patients/table', [PractitionerController::class, 'datatable'])->name('patients.datatable');
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

Route::middleware(['guest'])->group(function () {
    Route::get('/practitioner/login', function () {
        return view('frontend.auth.login-practitioner');
    })->name('practitioner.login');

    Route::get('/organization/login', function () {
        return view('frontend.auth.login-organization');
    })->name('organization.login');
});

Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::group([
    'prefix' => 'register',
    'as'     => 'register.',
], function () {
    Route::get('/', [PatientController::class, 'registerFlow'])->name('index');
    Route::get('/success', [PatientController::class, 'successFlow'])->name('success'); //role patient doesnt work here. Needs auth, role patient middleware
});

Route::group([
    'prefix' => '',
    'as'     => 'patient-flow.',
], function () {
Route::get('welcome-back' , [PatientController::class, 'showWelcomeBack'])->name('welcome-back');
Route::get('login/old' , [PatientController::class, 'showLoginOld'])->name('login-old');
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

//Route::group([
//    'prefix' => 'mock',
//    'as'     => 'mock.',
//], function () {
//    Route::post('patients/table', [RegainPatientController::class, 'patientsDatatable'])->name('patients.datatable'); //remove when done
//    Route::get('/date-of-birth', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showDateOfBirth'])->name('date-of-birth');
//    Route::get('/current-location', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showCurrentLocation'])->name('current-location');
//    Route::get('/disability-disorder', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showDisabilityDisorder'])->name('disability-disorder');
//
//    //Question levels
//    Route::group([
//        'prefix' => 'question',
//        'as'     => 'question.',
//    ], function () {
//        Route::get('/slider-answers', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'sliderIndex'])->name('slider-index');
//
//        Route::get('/level-1', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showQuestionLevelOne'])->name('question-level-1');
//        Route::get('/level-2', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showQuestionLevelTwo'])->name('question-level-2');
//        Route::get('/level-3', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showQuestionLevelThree'])->name('question-level-3');
//        Route::get('/level-4', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showQuestionLevelFour'])->name('question-level-4');
//    });
//
//    //Login flow Front
//    Route::get('flow/login', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showFlowLogin'])->name('login-flow');
//    Route::get('flow/info', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showFlowInfo'])->name('info-flow');
//    Route::get('flow/info-second', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showFlowInfoSecond'])->name('info-flow');
//    Route::get('flow/welcome-back', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showFlowWelcomeBack'])->name('welcome-back-flow');
//    Route::get('flow/login-video', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showFlowLoginVideo'])->name('login-video-flow');
//
//    Route::get('questions/welcome-to-regain' , [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showWelcomeToRegain'])->name('welcome-to-regain');
//
////    Dashboards
//    Route::get('organization/dashboard', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showOrganizationDashboard'])->name('organization-dashboard');
//    Route::get('practitioner/dashboard', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showPractitionerDashboard'])->name('practitioner-dashboard');
//    Route::get('practitioner/dashboard/calendar', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showPractitionerCalendarDashboard'])->name('practitioner-dashboard');
//    Route::get('practitioner/dashboard/export-pdf/three', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'previewThreeBarReport']);
//    Route::get('practitioner/dashboard/export-pdf/four', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'previewFourBarReport']);
//    Route::get('dashboard/login', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showLoginDashboard'])->name('login-dashboard');
//    Route::get('email', [\App\Domains\MockFront\Http\Controllers\MockFrontController::class, 'showEmail'])->name('email');
//});



// Email Testing
//use App\Mail\RegainEmail;
//use Illuminate\Support\Facades\Mail;
//Route::get('/test-email', function () {
//    // Simulate a user (replace with actual test user data)
//    $user = (object) [
//        'name' => 'georgia',
//        'email' => 'giannakos@cactusweb.gr'
//    ];
//
//    // Generate a random password
//    $password = '12345678georgia';
//
//    // Send the email
//    Mail::to($user->email)->send(new RegainEmail($user, $password));
//
//    return 'Test email sent successfully!';
//});
////
//Route::get('/preview-email', function () {
//    // Simulated user data
//    $user = (object) [
//        'name' => 'Georgia',
//        'email' => 'giannakos@cactusweb.gr'
//    ];
//
//    // Simulated password
//    $password = '12345678georgia';
//
//    // Return the Blade view for testing
//    return new RegainEmail($user, $password);
//});
