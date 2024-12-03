@php
    /**
     * @var App\Domains\Questions\Models\Question[] $questions
    */
@endphp
        <!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Site Metas -->
    <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/gif"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <title>Regain</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}"/>

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet"/>

    <!-- font awesome style -->
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet"/>
    <!-- Custom styles for this template -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet"/>
    <!-- responsive style -->
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet"/>

    <style>
        .rounded {
            border-radius: 55px; /* Adjust the px value as needed */
        }

        /* Ensure checkboxes are inline */
        .form-check-inline {
            margin-right: 15px; /* Add some space between checkboxes */
        }
    </style>
</head>

<body>

<div>
    <!-- header section starts -->
    <header class="header_section long_section px-0">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="index.html">
                <span>Regain</span>
            </a>
            <!-- Other header code omitted for brevity -->
        </nav>
    </header>
    <!-- end header section -->
</div>

<section class="blog_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 mx-auto">
                <div class="box rounded">
                    @foreach ($questions as $question)
                        <div class="detail-box">
                            <h5>{{$question->getTitle()}}</h5>
                            <form method="POST" id="input-form_{{$question->getId()}}" class="collect-question" data-question-id="{{$question->getId()}}" data-max-responses="2">
                                @csrf
                                @foreach ($question->getResponses() as $response)
                                    <div class="form-check form-check-inline">
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
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- One Next button below the question section -->
<section class="blog_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 mx-auto">
                <div class="box rounded">
                    <div class="detail-box">
                        <form method="POST" id="submit-form" action="{{ route('patient.submit-answer') }}">
                            @csrf
                            <input type="hidden" name="questionResponseIds[]" id="questionResponseIds"/>
                            <div class="form-group">
                                <button class="btn btn-primary" id="next-button" disabled>Next</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- footer section -->
<footer class="footer_section">
    <div class="container">
        <p>&copy; <span id="displayYear"></span> All Rights Reserved By
            <a href="https://www.cactusweb.gr/">Cactus</a>
        </p>
    </div>
</footer>

<!-- jQuery and Bootstrap scripts -->
<script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.js')}}"></script>

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

        // Initialize the "Next" button state
        updateNextButtonState(); // Check if the "Next" button should be enabled


    });
</script>

</body>
</html>
