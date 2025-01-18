<?php

namespace App\Domains\MockFront\Http\Controllers;

use App\Domains\Patient\Services\PatientDataService;
use App\Domains\Questions\Services\QuestionsService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Faker\Factory as Faker;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class MockFrontController extends  Controller
{
    public function __construct(private PatientDataService $patientDataService, private QuestionsService $questionsService,)
    {

    }

    private function generateQuestionsWithAnswers(int $count = 5): array
    {
        $faker = Faker::create('en_US');
        $likertScale = [
            'Strongly Disagree',
            'Disagree',
            'Neutral',
            'Agree',
            'Strongly Agree'
        ];

        $questionsWithAnswers = [];
        for ($i = 0; $i < $count; $i++) {
            $questionsWithAnswers[] = [
                'question' => $faker->sentence($nbWords = 8),
                'answers' => $likertScale,
            ];
        }

        return $questionsWithAnswers;
    }

    /**
     * @return View
     */
    public function showDateOfBirth(): View
    {
        return view('frontend.content.mock.date-of-birth');
    }

    public function showRegainInfo(): View
    {
        return view('frontend.content.mock.regain-info');
    }

    public function showCommunity(): View
    {
        return view('frontend.content.mock.community');
    }

    public function showHelpCenter(): View
    {
        return view('frontend.content.mock.help-center');
    }

    /**
     * @return View
     */
    public function showCurrentLocation(): View
    {
        $fakerLocales = ['ru_RU', 'uk_UA', 'ka_GE', 'lv_LV', 'lt_LT', 'et_EE', 'kz_KZ', 'by_BY'];
        $locations = [];

        for ($i = 0; $i < 27; $i++) {
            $locale = $fakerLocales[array_rand($fakerLocales)];
            $faker = Faker::create($locale);

            $locations[$i] = $faker->city();
        }


        return view('frontend.content.mock.current-location')->with('locations', $locations);
    }

    public function showDisabilityDisorder(): View
    {
        $questionsWithAnswers = $this->generateQuestionsWithAnswers();
        return view('frontend.content.mock.disability-disorder', [
            'questions' => array_column($questionsWithAnswers, 'question'),
            'answers' => array_column($questionsWithAnswers, 'answers'),
        ]);
    }

    public function showQuestionLevelOne(): View
    {
        $questionsWithAnswers = $this->generateQuestionsWithAnswers();
        return view('frontend.content.mock.question-levels.level1', [
            'questions' => array_column($questionsWithAnswers, 'question'),
            'answers' => array_column($questionsWithAnswers, 'answers'),
        ]);
    }

    public function showQuestionLevelTwo(): View
    {
        $questionsWithAnswers = $this->generateQuestionsWithAnswers();
        return view('frontend.content.mock.question-levels.level2', [
            'questions' => array_column($questionsWithAnswers, 'question'),
            'answers' => array_column($questionsWithAnswers, 'answers'),
        ]);
    }

    public function showQuestionLevelThree(): View
    {
        $questionsWithAnswers = $this->generateQuestionsWithAnswers();
        return view('frontend.content.mock.question-levels.level3', [
            'questions' => array_column($questionsWithAnswers, 'question'),
            'answers' => array_column($questionsWithAnswers, 'answers'),
        ]);
    }

    public function showQuestionLevelFour(): View
    {
        $questionsWithAnswers = $this->generateQuestionsWithAnswers();
        return view('frontend.content.mock.question-levels.level4', [
            'questions' => array_column($questionsWithAnswers, 'question'),
            'answers' => array_column($questionsWithAnswers, 'answers'),
        ]);
    }

    public function showOrganizationDashboard(): View
    {
        $columns = $this->patientDataService->getTableColumns();
        return view('frontend.content.mock.dashboards.organization.index')->with('columns', $columns);
    }

    public function showPractitionerDashboard(): View
    {
        $columns = $this->patientDataService->getTableColumns();
        return view('frontend.content.mock.dashboards.practitioner.index')->with('columns', $columns);
    }

    public function showPractitionerCalendarDashboard(): View
    {
        $columns = $this->patientDataService->getTableColumns();
        return view('frontend.content.mock.dashboards.practitioner.practinioner-calendar.index')->with('columns', $columns);
    }

    public function previewThreeBarReport()
    {
        $data = [
            'name' => 'Olha Maximova',
            'id' => '#145445',
            'dob' => '04/03/1985',
            'date' => '07.10.2024',
            'overview' => 'This report summarizes the findings from the Mental Health and Mental Pain assessment. It identifies patterns in emotional well-being, cognitive distortions, social connections, and physical symptoms. The goal is to provide actionable insights to improve mental health outcomes.',
            'subscales' => [
                [
                    'title' => 'Emotional Distress',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => true,
                    'indicator_2' => false,
                    'indicator_3' => false,
                ],
                [
                    'title' => 'Cognitive Distortions',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => false,
                    'indicator_2' => true,
                    'indicator_3' => false,
                ],
                [
                    'title' => 'Social Isolation',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => false,
                    'indicator_2' => false,
                    'indicator_3' => true,
                ],
                [
                    'title' => 'Physical Symptoms',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => false,
                    'indicator_2' => false,
                    'indicator_3' => false,
                ],
                [
                    'title' => 'Suicidal Thoughts',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => false,
                    'indicator_2' => true,
                    'indicator_3' => false,
                ],
                [
                    'title' => 'Self-esteem',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => true,
                    'indicator_2' => false,
                    'indicator_3' => false,
                ],
            ],
        ];

        return view('frontend.content.mock.dashboards.practitioner.exports.three.index', compact('data'));
    }

    public function previewFourBarReport()
    {
        $data = [
            'name' => 'Olha Maximova',
            'id' => '#145445',
            'dob' => '04/03/1985',
            'date' => '07.10.2024',
            'overview' => 'This report summarizes the findings from the Mental Health and Mental Pain assessment. It identifies patterns in emotional well-being, cognitive distortions, social connections, and physical symptoms. The goal is to provide actionable insights to improve mental health outcomes.',
            'subscales' => [
                [
                    'title' => 'Emotional Distress',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => true,
                    'indicator_2' => false,
                    'indicator_3' => false,
                    'indicator_4' => true,
                ],
                [
                    'title' => 'Cognitive Distortions',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => false,
                    'indicator_2' => true,
                    'indicator_3' => false,
                    'indicator_4' => false,
                ],
                [
                    'title' => 'Social Isolation',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => false,
                    'indicator_2' => false,
                    'indicator_3' => true,
                    'indicator_4' => true,
                ],
                [
                    'title' => 'Physical Symptoms',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => false,
                    'indicator_2' => false,
                    'indicator_3' => false,
                    'indicator_4' => false,
                ],
                [
                    'title' => 'Suicidal Thoughts',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => false,
                    'indicator_2' => true,
                    'indicator_3' => false,
                    'indicator_4' => true,
                ],
                [
                    'title' => 'Self-esteem',
                    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry...',
                    'indicator_1' => true,
                    'indicator_2' => false,
                    'indicator_3' => false,
                    'indicator_4' => true,
                ],
            ],
        ];

        return view('frontend.content.mock.dashboards.practitioner.exports.four.index', compact('data'));
    }


    public function showLoginDashboard(): View
    {
        return view('frontend.content.mock.dashboards.login.index');
    }


    public function showEmail(): View
    {
        return view('frontend.content.mock.email.index');
    }


    //Login Flow
    public function showFlowLogin(): View
    {
        return view('frontend.content.mock.login-flow.login');
    }

    public function showFlowInfo(): View
    {
        return view('frontend.content.mock.login-flow.info');
    }

    public function showFlowInfoSecond(): View
    {
        return view('frontend.content.mock.login-flow.info_second');
    }

    public function showFlowWelcomeBack(): View
    {
        return view('frontend.content.mock.login-flow.welcome-back');
    }

    public function sliderIndex(): \Illuminate\View\View
    {
        $presenter = $this->questionsService->fetchQuestionsAlt(Auth::id(), 10);

        return view('patient.index-alt')->with(
            ["presenter" => $presenter]
        );
    }
}
