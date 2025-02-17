@php
    /**
     * @var App\Domains\Questions\Models\QuestionsPresenter[] $presenter
     * @var string $previousInstruction;
     */
    $previousInstruction = "";
@endphp

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    input[type="checkbox"] {
        display: none;
    }
    .dob-container-questions {
        display: inline-block;
        border-radius: 4rem;
        flex-direction: column;
        margin: auto;
        min-width: 70rem;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        box-shadow: 0 4px 4px 0 #00000040;
        height: auto;
        max-height: none;
        width: auto;
    }

    .question-single {
        margin-bottom: 40px;
    }

    .question-single:last-child {
        margin-bottom: 0;
    }

    input[type="radio"] {
        display: none;
    }

    .grid-layout-second {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        gap: 0;
    }

    .grid-layout-second li {
        list-style: none;
        flex: 1; /* Makes each <li> take an equal portion of space */
        text-align: center;
    }

    label.toggle {
        cursor: pointer;
        background-color: #f0f0f0;
        padding: 5px;
        border: 1px solid rgba(159, 159, 159, 1);
        border-radius: 0 !important;
        font-size: 15px;
        font-weight: 400;
        text-align: center;
        transition: all 0.3s ease;
        width: 100%;
        height: 50px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .grid-layout-second li:first-child label.toggle{
        border-top-left-radius: 0.4rem !important;
        border-bottom-left-radius: 0.4rem !important;
    }

    .grid-layout-second li:last-child label.toggle{
        border-top-right-radius: 0.4rem !important;
        border-bottom-right-radius: 0.4rem !important;
    }

    label.toggle:hover {
        background-color: #e0e0e0;
    }

    input[type="radio"]:checked + label.toggle {
        background-color: rgba(10, 19, 58, 1);
        color: #fff;
        border-color: rgba(10, 19, 58, 1);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .question-span {
        font-size: 16px;
        font-weight: 700;
        line-height: 22px;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
    }

    @media (max-width: 990px) {
        .grid-layout-second {
            grid-template-columns: 1fr;
            gap: 0.5rem;
            justify-items: unset;
        }

        label.toggle {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .dob-container-questions {
            margin: auto;
        }

        .text-heading > a {
            display: none !important;
        }
    }
</style>
</head>
<body>

@vite(['resources/css/patient-index.css'])

@include('patient.includes.navbar')

<div class="dob-container-questions">
    @if ($presenter->isCompleted())
        <div class="container py-5 my-4">
            <div class="question m-5">
                <div class="thank-you-content d-flex flex-column align-items-center justify-content-center ">
                    <span class="question-span text-center">Thank you for your participation!</span>
                    <div class="d-flex justify-content-center mt-4">
                        {{--                        <button type="button" class="btn btn-primary mt-5">Go Back to Regain</button>--}}
                    </div>
                </div>
            </div>
        </div>
    @else
        @foreach ($presenter->getQuestions() as $question)
            <div class=" container px-3 py-2 {{$question->isHiddenBecauseOfRequired() ? "hidden" : ""}}"
                 data-hide="{{$question->isHiddenBecauseOfRequired() ? "true" : "false"}}">
                <form
                    id="input-form_{{$question->getId()}}"
                    class="collect-question"
                    data-question-id="{{$question->getId()}}"
                    data-condition-question-id="{{$question->getRequiredQuestionId()}}"
                    data-condition-required-response-ids="[{{implode(", ", $question->getRequiredQuestionResponseIds())}}]"
                    @if ($question->isSelectMultiple())
                        data-max-selections="{{count($question->getResponses())}}"
                    @else
                        data-max-selections="1"
                    @endif
                >
                    @csrf
                    <div class="question mb-5 question-single">
                        <span class="question-span">{{$question->getTitle()}}
                            @if ($question->getInstruction()->getContent() !== $previousInstruction)
                                ({{$question->getInstruction()->getContent()}})
                                @php $previousInstruction = $question->getInstruction()->getContent(); @endphp
                            @endif
                        </span>
                        @if ($question->getId() !== 11)
                            <ul class="list-unstyled grid-layout-second mt-3">
                                @foreach ($question->getResponses() as $response)
                                    <li>
                                        <input
                                            type="checkbox"
                                            class="select-response radio-label round"
                                            data-question-id="{{$question->getId()}}"
                                            data-response-id="{{$response->getId()}}"
                                            id="response-{{$question->getId()}}-{{$response->getId()}}"
                                            name="response-{{$question->getId()}}[]">
                                        <label for="response-{{$question->getId()}}-{{$response->getId()}}" class="toggle">
                                            <span class="radio-label round">{{ $response->getTitle() }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div style="width: 100%; margin-top: 20px;">
                                <select class="select2 select-response round"
                                        style="width: 50%; height: 40px;"
                                        data-question-id="{{$question->getId()}}"
                                        name="response-{{$question->getId()}}[]"
                                        data-response-id=""
                                        placeholder="Test">
                                    <option value="">Test</option>
                                    @foreach ($question->getResponses() as $response)
                                        <option value="{{$response->getId()}}">
                                            {{ $response->getTitle() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        @endforeach

        <div class="d-flex justify-content-center">
            <form id="submit-form">
                <button type="button" class="btn btn-primary mt-3" id="next-button" disabled>Next</button>
            </form>
        </div>
    @endif
</div>
<div id="overlay" class="overlay">
    <div class="spinner"></div>
</div>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });

    // $('#mySelect').on('select2:select', function (e) {
    //     var selectedValue = e.params.data.id;
    //     console.log("Selected value:", selectedValue);
    // });

    document.addEventListener('DOMContentLoaded', function () {

        $('.select2').on('change', function () {
            $('.select2')[0].dataset.responseId = $(this).val();
            updateNextButtonState();
        });

        const nextButton = document.getElementById('next-button');
        const checkboxes = document.querySelectorAll('.select-response');

        // Function to handle checkbox change and update the 'Next' button state
        function updateNextButtonState() {
            let missing = false;
            checkboxes.forEach(checkbox => {
                const questionId = checkbox.dataset.questionId;
                const questionForm = document.getElementById(`input-form_${questionId}`);
                const container = questionForm.closest('.container');

                if (container && container.dataset.hide !== "true") {
                    if (checkbox.tagName === "SELECT") {
                        if (!checkbox.dataset.responseId) {
                            missing = true;
                        }
                    } else {
                        const checkboxesForQuestion = questionForm.querySelectorAll('input[name="response-' + questionId + '[]"]:checked');
                        if (checkboxesForQuestion.length === 0) {
                            missing = true;
                        }
                    }
                }
            });
            nextButton.disabled = missing;
        }


        // Event listener for checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', function (event) {
                const questionId = this.dataset.questionId;

                const inputForm = document.getElementById(`input-form_` + questionId);
                const maxSelections = inputForm.dataset.maxSelections;
                const formAvailableCheckBoxes = inputForm.querySelectorAll('input[name="response-' + questionId + '[]"]');
                const formCheckedBoxes = Array.from(formAvailableCheckBoxes).filter(checkbox => checkbox.checked);
                if (formCheckedBoxes.length > maxSelections) {
                    formAvailableCheckBoxes.forEach(cb => {
                        if (cb !== event.currentTarget) {
                            cb.checked = false;
                        }
                    });
                }

                const dependantForms = document.querySelectorAll('form[data-condition-question-id]:not([data-condition-question-id=""])');
                dependantForms.forEach(form => {
                    requiredQuestionId = form.dataset.conditionQuestionId;
                    requiredForm = document.getElementById(`input-form_` + requiredQuestionId);
                    requiredQuestionResponseIds = JSON.parse(form.dataset.conditionRequiredResponseIds);
                    parentForm = document.getElementById(`input-form_` + requiredQuestionId);
                    questionContainer = form.closest('.container');
                    if (parentForm) {
                        requiredFormInputs = parentForm.querySelectorAll(`input:checked`);
                        if (requiredFormInputs.length > 0) {
                            // Check if any of the selected inputs have a response ID that matches any in the required response IDs array
                            const containsAnyId = Array.from(requiredFormInputs).some(input =>
                                requiredQuestionResponseIds.includes(parseInt(input.dataset.responseId))
                            );

                            if (containsAnyId) {
                                if (questionContainer) {
                                    questionContainer.classList.remove('hidden');
                                    questionContainer.dataset.hide = "false"
                                }
                            } else {
                                questionContainer.classList.add('hidden');
                                questionContainer.dataset.hide = "true"
                            }
                        } else {
                            questionContainer.classList.add('hidden');
                            questionContainer.dataset.hide = "true"
                        }
                    }

                });
                updateNextButtonState();
            });
        });

        // Handle Next button click
        nextButton.addEventListener('click', function (e) {
                e.preventDefault();

                // Show the overlay and disable the button
                overlay.style.display = 'flex';
                nextButton.disabled = true;

                // Collect the selected response IDs for this question
                let selectedResponsesFinal = [];
                document.querySelectorAll(`.collect-question`)
                    .forEach(questionForm => {
                        questionContainer = questionForm.closest('.container');
                        if (questionContainer.dataset.hide === "false") {
                            questionData = {};
                            questionData.questionId = parseInt(questionForm.dataset.questionId);
                            questionData.responses = [];

                            // Add the selected response ID to the questionData object
                            if (!questionForm.dataset.select2Id) {
                                responses = questionForm.querySelectorAll(`.select-response:checked`).forEach(response => {
                                    questionData.responses.push(parseInt(response.dataset.responseId));
                                });
                            } else {
                                response = questionForm.querySelectorAll("select")[0].dataset.responseId;
                                questionData.responses.push(parseInt(response));
                            }

                            selectedResponsesFinal.push(questionData);
                        }
                    });


                if (selectedResponsesFinal.length > 0) {
                    // Send the collected data via JSON
                    fetch('{{ route('patient.submit-answers') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({questions: selectedResponsesFinal})
                    })
                        .then(response => response.json())
                        .then(data => {
                            // Handle the response from the server (e.g., show a success message, redirect)
                            window.location.href = '{{ route('patient.ask') }}';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }
        );

        overlay.style.display = 'none';
        nextButton.disabled = false;

        // Initialize the "Next" button state
        updateNextButtonState();
    });
</script>
</body>
</html>
