@php
    /**
     * @var App\Domains\Questions\Models\QuestionsPresenter[] $presenter
    */
@endphp

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>

@vite(['resources/css/patient-index.css'])

@include('frontend.content.mock.includes.navbar')

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
                        @endif
                >
                    @csrf
                    <div class="question mb-5">
                        <span class="question-span">{{$question->getTitle()}} ({{$question->getInstruction()->getContent()}})</span>
                        @if ($question->getId() !== 11)
                            <ul class="list-unstyled grid-layout mt-3">
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
        $(document).ready(function() {
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

        $('.select2').on('change', function() {
            $('.select2')[0].dataset.responseId = $(this).val();
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
                    const checkboxesForQuestion = questionForm.querySelectorAll('input[name="response-' + questionId + '[]"]:checked');
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
