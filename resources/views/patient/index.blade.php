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
    <style>
        .grid-layout {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
            justify-items: center;
            align-items: center;
        }

        .grid-layout li {
            list-style: none;
            text-align: center;
            text-wrap: nowrap;
        }

        input[type="radio"] {
            appearance: none;
            width: 0.9rem;
            height: 0.9rem;
            border: 2px solid #161B2C;
            border-radius: 100%;
            position: relative;
            cursor: pointer;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        input[type="radio"]:hover,
        label.toggle:hover + input[type="radio"] {
            border-color: #555;
        }

        label.toggle:hover + input[type="radio"] {
            background-color: #f0f0f0;
        }

        input[type="radio"]:checked {
            background-color: #333;
            border-color: #333;
        }

        label.toggle {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0.3rem 0.3rem;
            border-radius: 0.5rem;
        }

        label.toggle:hover {
            background-color: #f0f0f0;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        input[type="radio"]:checked + label.toggle {
            background-color: #151B2C;
            color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        label.toggle:hover + input[type="radio"]:checked {
            background-color: #333;
            border-color: #333;
        }

        .question-span {
            font-size: 16px;
            font-weight: 700;
            line-height: 22px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        .radio-label {
            font-size: 15px;
            font-weight: 400;
        }

        @media (max-width: 990px) {
            .grid-layout {
                display: flex;
                flex-direction: column;
                justify-content: start;
                align-items: start;
            }

            .grid-layout ul {
                display: flex;
                flex-wrap: nowrap;
                justify-content: center;
                align-items: center;
                padding: 0;
                margin: 0;
            }
        }

    </style>
</head>
<body>

<video class="video-background" autoplay muted loop>
    <source
            src="https://s3-figma-videos-production-sig.figma.com/video/1309080390110430302/TEAM/1e82/00ac/-1b93-4cf6-acd8-68ac308285fd?Expires=1733702400&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=oorEDXdUAETvyCVU7BK8hb7EhdlCg53KlsncAE7Q1cIR8umuliZzbLcggOlyHA41GoRkvXwvzgGEh9Lx-fQiwV0Ri-G7ri5D5ovhDWrLnKcX564t8ughfnmtru1oG3ln6q6C4TNvsPCPAe~zQ9tSnnmDfrha3V7HjNqutPflCKk3kNIDpwHEy4X2Cw3a3c-ZdN9NeRtFabz42~VTvb2IoYcXx5GiOY5NMsjqsXqjOYt~a0JGnc49hTyXHyLDtkOYzhXzSZCGkbPplj28biet78gPFyzVN2fSehm0aYoVgjiEuLbua6BJ~n2Dj0Lf7FeulAQVOp6721-80D39XsAfDw__"
            type="video/mp4">
    Your browser does not support the video tag.
</video>

@include('frontend.content.mock.includes.navbar')

<div class="dob-container">
    {{--    <div class="d-flex justify-content-between align-items-center" style="width: 99%; margin: 0 auto">--}}
    {{--        <a href="#" class="btn btn-link text-decoration-none">&larr; Back</a>--}}
    {{--    </div>--}}

    @foreach ($questions as $question)
        <div class="container px-5 py-2 pb-5">
            <form id="input-form_{{$question->getId()}}" class="collect-question" data-question-id="{{$question->getId()}}" data-max-responses="2">
                @csrf
                <div class="question mb-5">
                    <span class="question-span">{{$question->getTitle()}}</span>
                    <ul class="list-unstyled grid-layout mb-4 mt-1">
                        @foreach ($question->getResponses() as $response)
                            <li>
                                <input
                                        type="checkbox"
                                        class="select-response"
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
        <button type="submit" class="btn btn-primary mt-3">Next</button>
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
            if (selectedResponses.length > 2) {
                alert('You can select up to 2 responses only.');
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
                        selectedResponses.push(checkbox.dataset.responseId);
                    });

                // Add selected responses to the hidden input
                selectedResponses.forEach(responseId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'questionResponseIds[]';
                    input.value = responseId;
                    form.appendChild(input);
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


    });
</script>
</body>
</html>
