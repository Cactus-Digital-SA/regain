<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css" rel="stylesheet">
    <style>
        .slider {
            margin: auto;
            width: 100%;
            z-index: 3;
        }

        .question-span-div {
            margin-bottom: 10px;
        }

        .noUi-target {
            background: rgba(159, 159, 159, 1) !important;
            border: unset;
            box-shadow: unset;
            border-radius: 5px;
            height: 4px;
            position: relative;
        }

        .noUi-connect {
            background: #151b2c;
            border-radius: 5px;
        }

        .noUi-marker {
            display: none;
        }

        .noUi-handle {
            position: absolute;
            top: -8px !important;
            max-width: 20px;
            max-height: 20px;
            border: 3px solid #151b2c;
            background: #fff;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        .noUi-handle:hover,
        .noUi-handle:focus {
            transform: scale(1.2);
            background-color: #e0e0e0;
        }

        .noUi-pips .noUi-value {
            font-size: 15px;
            font-weight: 400;
            line-height: 18.15px;
            text-align: center;
            margin-top: 0;
            cursor: pointer;
        }

        .noUi-value:hover {
            color: #757CA0;
        }

        .noUi-pips-horizontal {
            width: 101%;
        }

        .noUi-value.highlighted {
            color: rgba(39, 52, 61, 1);
            font-weight: bold;
        }

        .noUi-handle:after, .noUi-handle:before {
            background: none;
        }

        @media (max-width: 990px) {
            .question-single {
                padding: 10px;
            }

            .slider {
                width: 100%;
            }

            .slider-background {
                display: none;
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
                <div class="thank-you-content d-flex flex-column align-items-center justify-content-center">
                    <span class="question-span text-center">Thank you for your participation!</span>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="button" class="btn btn-primary mt-5">Go Back to Regain</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        @foreach ($presenter->getQuestions() as $index => $question)
            @php
                $responses = array_map(fn($response) => $response->getTitle(), $question->getResponses());
            @endphp
            <div class="container px-3 py-2 {{$question->isHiddenBecauseOfRequired() ? "hidden" : ""}}"
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
                        @endif>
                    @csrf
                    <div class="question" style="margin-bottom: 5rem">
                        <div class="question-span-div">
                            <span class="question-span">{{$question->getTitle()}} ({{$question->getInstruction()->getContent()}})</span>
                        </div>
                        <div class="slider" id="slider-{{ $index }}"></div>
                        <ul class="list-unstyled mt-3 checkbox-list hidden">
                            @foreach ($question->getResponses() as $response)
                                <li>
                                    <input
                                            type="checkbox"
                                            class="select-response"
                                            data-question-id="{{$question->getId()}}"
                                            data-response-id="{{$response->getId()}}"
                                            id="response-{{$question->getId()}}-{{$response->getId()}}"
                                            name="response-{{$question->getId()}}[]">
                                    <label for="response-{{$question->getId()}}-{{$response->getId()}}">
                                        {{$response->getTitle()}}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </div>
        @endforeach

        <div class="d-flex justify-content-center">
            <form id="submit-form">
                <button type="button" class="btn btn-primary mt-3" id="next-button">Next</button>
            </form>
        </div>
    @endif
</div>
<div id="overlay" class="overlay">
    <div class="spinner"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sliderValues = {}; // Object to track the slider values by questionId

        // Initialize of sliders based on the index of questions
        const questions = @json(array_map(function ($question) {
        return array_map(function ($response) {
                return $response->getTitle();
            }, $question->getResponses());
        }, $presenter->getQuestions()));

        questions.forEach((responses, index) => {
            const sliderElement = document.getElementById(`slider-${index}`);
            const questionId = parseInt(sliderElement.closest('.collect-question').dataset.questionId);
            const checkboxList = sliderElement.closest('.collect-question').querySelector('.checkbox-list');

            responses = ["", ...responses];

            noUiSlider.create(sliderElement, {
                start: [0],
                range: {
                    min: 0,
                    max: responses.length,
                },
                connect: 'lower',
                pips: {
                    mode: 'values',
                    values: [...Array(responses.length).keys()],
                    density: 100,
                    format: {
                        to: value => responses[Math.round(value)],
                    },
                },
            });

            sliderValues[questionId] = null;
            let isSnapping = false; // Prevent multiple snaps during interactions

            // Snapping functionality
            sliderElement.noUiSlider.on('set', function (values, handle) {
                if (isSnapping) return;
                isSnapping = true;

                const snappedValue = Math.round(values[handle]);
                sliderElement.noUiSlider.set(snappedValue);
                sliderValues[questionId] = snappedValue === 0 ? null : snappedValue - 1; // Adjust for "Select an option"

                // Update checkboxes to reflect snapped value
                checkboxList.querySelectorAll('input').forEach((checkbox, idx) => {
                    if (idx === sliderValues[questionId] && idx !== null) {
                        checkbox.click();
                    } else {
                        checkbox.checked = false;
                        updateNextButtonState();
                    }
                });

                isSnapping = false;
            });

            // Highlight slider pips during update
            sliderElement.noUiSlider.on('update', function (values, handle) {
                const valueIndex = Math.round(values[handle]);
                document.querySelectorAll(`#slider-${index} .noUi-value`).forEach((pip, idx) => {
                    if (idx === 0 || idx === null) {
                        pip.classList.add('unselected');
                    }
                    pip.classList.toggle('highlighted', idx === valueIndex);
                });
            });

            sliderElement.querySelectorAll('.noUi-value').forEach((pip, pipIndex) => {
                pip.addEventListener('click', () => {
                    sliderElement.noUiSlider.set(pipIndex);

                    checkboxList.querySelectorAll('input').forEach((checkbox, idx) => {
                        checkbox.checked = idx === pipIndex - 1; // Adjust for "Select an option"
                    });

                    sliderValues[questionId] = pipIndex === 0 ? null : pipIndex - 1;

                    updateNextButtonState();
                });
            });

            if (responses.length >= 7) {
                sliderElement.querySelectorAll('.noUi-value').forEach(pip => {
                    pip.style.fontSize = '0.8rem';
                    pip.style.top = '0';
                });
            }

            // Update slider when checkbox is clicked
            checkboxList.querySelectorAll('input').forEach((checkbox, idx) => {
                checkbox.addEventListener('change', function () {
                    if (checkbox.checked) {
                        sliderElement.noUiSlider.set(idx + 1); // Adjust for null
                        sliderValues[questionId] = idx;
                    }
                });
            });
        });

        const nextButton = document.getElementById('next-button');
        const checkboxes = document.querySelectorAll('.select-response');

        // Function to handle checkbox change and update the 'Next' button state
        function updateNextButtonState() {
            let missing = false;
            checkboxes.forEach(checkbox => {
                const questionId = checkbox.dataset.questionId;
                const form = document.getElementById(`input-form_${questionId}`);
                const container = form.closest('.container');
                if (container && container.dataset.hide !== "true") {
                    const checkboxesForQuestion = form.querySelectorAll('input[name="response-' + questionId + '[]"]:checked');
                    if (checkboxesForQuestion.length === 0) {
                        missing = true;
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
                            responses = questionForm.querySelectorAll(`.select-response:checked`).forEach(response => {
                                questionData.responses.push(parseInt(response.dataset.responseId));
                            });

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
                            window.location.href = '{{ route('patient.home') }}';
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
