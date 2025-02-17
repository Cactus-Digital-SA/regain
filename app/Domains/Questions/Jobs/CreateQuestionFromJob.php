<?php

namespace App\Domains\Questions\Jobs;

use App\Domains\Questions\Import\QuestionsImport;
use App\Domains\Questions\Repositories\Eloquent\EloqQuestionRepository;
use App\Domains\Questions\Repositories\Eloquent\Models\Question;
use App\Domains\Questions\Repositories\Eloquent\Models\QuestionResponse;
use App\Domains\Questions\Services\QuestionsService;
use App\Domains\Responses\Repositories\Eloquent\EloqResponseRepository;
use App\Domains\Responses\Repositories\Eloquent\Models\Response;
use App\Domains\Responses\Services\ResponseService;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateQuestionFromJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Collection $question,
    ) {
    }

    /**
     * Execute the job.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        $questionService = Container::getInstance()->get(QuestionsService::class);
        $responseService = Container::getInstance()->get(ResponseService::class);

        $row = $this->question;

        $id       = (int)Helpers::extractIntegerFromString($row['unique_id']);
        $category = (string)$row['category'];
        $subscale = (string)$row['subscale'];

        if ($category !== "MEDICAL HISTORY") {
            $test           = (string)$row['test'];
            $referenceType  = (string)$row['reference_group'];
            $referenceGroup = (int)Helpers::extractIntegerFromString($row['reference']);
        } else {
            $test          = "MEDICAL HISTORY";
            $referenceType = "MEDICAL HISTORY";
        }

        $instructions = (string)$row['instructions'];
        $question     = (string)$row['question'];

        $selectMultiple = array_key_exists('multiple', $row->toArray()) && (int)$row['multiple'] === 1;

        $requiredQuestion  = array_key_exists('required_question', $row->toArray()) ? $row['required_question'] : null;
        $requiredResponses = array_key_exists('required_response', $row->toArray()) ? $row['required_response'] : null;
        $userInput         = array_key_exists('user_input', $row->toArray()) ? $row['user_input'] ?? false : false;

        /**  Get Responses */
        $responses = [];

        if ($referenceType != 'Medication Reference' && $test != 'Professional Sector') {
            foreach ($row as $key => $value) {
                if (str_starts_with($key, "response") && str_contains($key, 'response') && !empty($value) && $value !== '-') {
                    $responses[] = ['value' => (string)$value, 'type' => 1, 'sort' => null];
                }
            }
        }

        if ($referenceType == 'Medication Reference') {
            $responses  = [];
            $medication = QuestionsImport::getMedications();
            foreach ($medication as $value) {
                $responses[] = ['value' => $value, 'type' => 2, 'sort' => null];
            }
        }

        if ($test == 'Professional Sector') {
            $responses = [];
            foreach ($row as $key => $value) {
                if (str_contains($key, 'response') && !empty($value) && $value !== '-') {
                    $responses[] = ['value' => (string)$value, 'type' => 3, 'sort' => null];
                }
            }
        }

        /**  Create or Find Language */
        $language_id = QuestionsImport::findLanguage('en');
        if (!$language_id) {
            throw new Exception('Language not found');
        }

        /**  Create category */
        $categoryId = QuestionsImport::createCategory($category);

        /**  Create Test & Assign Test ID */
        $testId = QuestionsImport::createTest($test, $categoryId);

        /**  Create Subscale & Assign Test ID */
        $subscaleId = QuestionsImport::createSubscale($subscale, $testId);

        /** Instruction Creation */
        $instruction_id = QuestionsImport::createInstruction($instructions, $language_id);

        if ($row['unique_id'] === 11) /**  Create Responses */ {
            $countryResponses = [];
            foreach (self::getCountries() as $key => $value) {
                $countryResponses[] = ['value' => $value, 'type' => 1, 'sort' => null];
            }
            $responsesIds = QuestionsImport::createResponses($countryResponses, $language_id);
        } else {
            $responsesIds = QuestionsImport::createResponses($responses, $language_id);
        }

        /**  Get References */
        $referencesIds = [];
        if ($category !== "MEDICAL HISTORY") {
            $referencesIds = QuestionsImport::getReferences($referenceType, $referenceGroup);
        }

        /** Required Question and responses for the question to show */
        $requiredResponsesIds = [];
        if ($requiredQuestion && $requiredQuestion !== '-') {
            $requiredQuestionId = (int)Helpers::extractIntegerFromString($row['required_question']);
            if (str_starts_with($requiredResponses, 'RESPONSE')) {
                $requiredResponsesList  = QuestionResponse::where('question_id', $requiredQuestionId)->get("id")->toArray();
                $trimmedResponses       = str_replace(['RESPONSE', '#'], '', $requiredResponses);
                $requiredResponsesArray = explode(',', $trimmedResponses);
                /** @var Collection $requiredResponse */
                $requiredResponsesIds = array_map(function ($index) use ($requiredResponsesList) {
                    return $requiredResponsesList[(int)$index - 1]["id"];  // Subtract 1 to get the correct index
                }, $requiredResponsesArray);
            } else {
                $requiredResponsesArray = explode(',', $requiredResponses);
                foreach ($requiredResponsesArray as $requiredResponse) {
                    $callable = function (Builder $query) use ($requiredResponse) {
                        $query->where(DB::raw("UPPER(title)"), "=", trim($requiredResponse));
                    };

                    $row = QuestionResponse::where('question_id', $requiredQuestionId)->whereHas("response", $callable)->first();
                    if ($row->count() > 0) {
                        $requiredResponsesIds[] = $row->id;
                    }
                }
            }
        } else {
            $requiredQuestionId = null;
        }

        $questionDTO = new \App\Domains\Questions\Models\Question();

        $questionDTO->setTestId($testId);
        $questionDTO->setSubscaleId($subscaleId);
        $questionDTO->setInstructionId($instruction_id);
        $questionDTO->setReferences($referencesIds);
        $questionDTO->setResponses($responsesIds);
        $questionDTO->setTitle($question);
        $questionDTO->setSort(null);
        $questionDTO->setStatus(1);
        $questionDTO->setRequiredResponses($requiredResponsesIds);
        $questionDTO->setLanguages([$language_id => ['question' => $question]]);
        $questionDTO->setUserInput($userInput);
        $questionDTO->setSelectMultiple($selectMultiple);

        $questionService->storeWithId($questionDTO, $id);
    }

    public static function getCountries(): array
    {
        return [
            "Afghanistan",
            "Albania",
            "Algeria",
            "Andorra",
            "Angola",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bhutan",
            "Bolivia",
            "Bosnia and Herzegovina",
            "Botswana",
            "Brazil",
            "Brunei",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cabo Verde",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Colombia",
            "Comoros",
            "Congo (Congo-Brazzaville)",
            "Costa Rica",
            "Croatia",
            "Cuba",
            "Cyprus",
            "Czechia (Czech Republic)",
            "Democratic Republic of the Congo",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Eswatini (Swaziland)",
            "Ethiopia",
            "Fiji",
            "Finland",
            "France",
            "Gabon",
            "Gambia",
            "Georgia",
            "Germany",
            "Ghana",
            "Greece",
            "Grenada",
            "Guatemala",
            "Guinea",
            "Guinea-Bissau",
            "Guyana",
            "Haiti",
            "Honduras",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran",
            "Iraq",
            "Ireland",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Kuwait",
            "Kyrgyzstan",
            "Laos",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Mauritania",
            "Mauritius",
            "Mexico",
            "Micronesia",
            "Moldova",
            "Monaco",
            "Mongolia",
            "Montenegro",
            "Morocco",
            "Mozambique",
            "Myanmar (Burma)",
            "Namibia",
            "Nauru",
            "Nepal",
            "Netherlands",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "North Korea",
            "North Macedonia",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Palestine",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Poland",
            "Portugal",
            "Qatar",
            "Romania",
            "Russia",
            "Rwanda",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Vincent and the Grenadines",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Serbia",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Slovakia",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "South Korea",
            "South Sudan",
            "Spain",
            "Sri Lanka",
            "Sudan",
            "Suriname",
            "Sweden",
            "Switzerland",
            "Syria",
            "Tajikistan",
            "Tanzania",
            "Thailand",
            "Timor-Leste",
            "Togo",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "United States",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Vatican City",
            "Venezuela",
            "Vietnam",
            "Yemen",
            "Zambia",
            "Zimbabwe"
        ];
    }
}
