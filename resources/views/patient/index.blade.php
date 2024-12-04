@php
    /**
     * @var App\Domains\Questions\Models\Question[] $questions
    */
@endphp

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@vite(['resources/css/patient-index.css'])

<video class="video-background" autoplay muted loop>
    <source
            src="https://s3-figma-videos-production-sig.figma.com/video/1309080390110430302/TEAM/1e82/00ac/-1b93-4cf6-acd8-68ac308285fd?Expires=1733702400&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=oorEDXdUAETvyCVU7BK8hb7EhdlCg53KlsncAE7Q1cIR8umuliZzbLcggOlyHA41GoRkvXwvzgGEh9Lx-fQiwV0Ri-G7ri5D5ovhDWrLnKcX564t8ughfnmtru1oG3ln6q6C4TNvsPCPAe~zQ9tSnnmDfrha3V7HjNqutPflCKk3kNIDpwHEy4X2Cw3a3c-ZdN9NeRtFabz42~VTvb2IoYcXx5GiOY5NMsjqsXqjOYt~a0JGnc49hTyXHyLDtkOYzhXzSZCGkbPplj28biet78gPFyzVN2fSehm0aYoVgjiEuLbua6BJ~n2Dj0Lf7FeulAQVOp6721-80D39XsAfDw__"
            type="video/mp4">
    Your browser does not support the video tag.
</video>

@include('frontend.content.mock.includes.navbar')

<div class="dob-container">
    @foreach ($questions as $question)
        <div class="container px-3 py-2 {{$question->isHiddenBecauseOfRequired() ? "hidden" : ""}}" data-hide="{{$question->isHiddenBecauseOfRequired() ? "true" : "false"}}">
            <form id="input-form_{{$question->getId()}}" class="collect-question" data-question-id="{{$question->getId()}}" data-condition-question-id="{{$question->getRequiredQuestionId()}}" data-condition-required-response-ids="[{{implode(", ", $question->getRequiredQuestionResponseIds())}}]">
                @csrf
                <div class="question mb-5">
                    <span class="question-span">{{$question->getTitle()}}</span>
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
                </div>
            </form>
        </div>
    @endforeach
    <div class="d-flex justify-content-center">
        <form id="submit-form">
            <button type="button" class="btn btn-primary mt-3" id="next-button" disabled>Next</button>
        </form>
    </div>
</div>
<div id="overlay" class="overlay">
    <div class="spinner"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nextButton = document.getElementById('next-button');
        const checkboxes = document.querySelectorAll('.select-response');

        // Initialize an object to track if all questions have been answered
        const answeredQuestions = {};

        // Function to handle checkbox change and update the 'Next' button state
        function updateNextButtonState() {
            const allAnswered = Object.values(answeredQuestions).every(isAnswered => isAnswered);
            nextButton.disabled = !allAnswered; // Enable "Next" only if all questions are answered
        }

        // Function to handle max selections logic
        function enforceMaxSelections(questionId) {
            const form = document.getElementById(`input-form_${questionId}`);
            const checkboxes = form.querySelectorAll('input[name="response-' + questionId + '[]"]');
            const selectedResponses = Array.from(checkboxes).filter(checkbox => checkbox.checked);

            // Limit to max 2 selections
            if (selectedResponses.length > 1) {
                alert('You can select up to 1 responses only.');
                // Uncheck the last selected checkbox to respect the max selection
                selectedResponses[selectedResponses.length - 1].checked = false;
            }

            // Update the Next button state
            updateNextButtonState();
        }

        // Initialize answeredQuestions by checking the current state of all questions
        checkboxes.forEach(checkbox => {
            const questionId = checkbox.dataset.questionId;
            const form = document.getElementById(`input-form_${questionId}`);
            const checkboxesForQuestion = form.querySelectorAll('input[name="response-' + questionId + '[]"]:checked');
            answeredQuestions[questionId] = checkboxesForQuestion.length > 0;
        });

        // Event listener for checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const questionId = this.dataset.questionId;

                // Enforce max selections (limit to 2)
                enforceMaxSelections(questionId);

                // Update the hidden input for responses
                const form = document.getElementById(`submit-form`);
                const responseInputs = form.querySelectorAll('input[name="questionResponseIds[]"]');
                responseInputs.forEach(input => input.remove());

                // Collect selected response IDs
                const selectedResponses = [];
                document.querySelectorAll(`input[name="response-${questionId}[]"]:checked`)
                    .forEach(checkbox => {
                        selectedResponses.push(parseInt(checkbox.dataset.responseId));
                    });


                const dependantForms = document.querySelectorAll('form[data-condition-question-id]:not([data-condition-question-id=""])');
                dependantForms.forEach(form => {
                    requiredQuestionId = form.dataset.conditionQuestionId;
                    requiredForm = document.getElementById(`input-form_` + requiredQuestionId);
                    requiredQuestionResponseIds = JSON.parse(form.dataset.conditionRequiredResponseIds);
                    parentForm = document.getElementById(`input-form_` + requiredQuestionId);
                    if (parentForm) {
                        requiredFormInputs = parentForm.querySelectorAll(`input:checked`);
                        if (requiredFormInputs.length > 0) {
                            // Check if any of the selected inputs have a response ID that matches any in the required response IDs array
                            const containsAnyId = Array.from(requiredFormInputs).some(input =>
                                requiredQuestionResponseIds.includes(parseInt(input.dataset.responseId))
                            );

                            if (containsAnyId) {
                                questionContainer = form.closest('.container');
                                if (questionContainer) {
                                    questionContainer.classList.remove('hidden');
                                }
                            } else {
                                questionContainer.classList.add('hidden');
                            }
                        } else {
                            questionContainer.classList.add('hidden');
                        }
                    }

                });

                // Track if this question is answered
                answeredQuestions[questionId] = selectedResponses.length > 0;
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
                        questionData = {};
                        questionData.questionId = parseInt(questionForm.dataset.questionId);
                        questionData.responses = [];

                        // Add the selected response ID to the questionData object
                        responses = questionForm.querySelectorAll(`.select-response:checked`).forEach(response => {
                            questionData.responses.push(parseInt(response.dataset.responseId));
                        });

                        selectedResponsesFinal.push(questionData);
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

        overlay.style.display = 'none'; // Hide the overlay if no responses were selected
        nextButton.disabled = false;

        // Initialize the "Next" button state
        updateNextButtonState(); // Check if the "Next" button should be enabled


    })
    ;
</script>
</body>
</html>
