<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css" rel="stylesheet">
    <style>
        .slider{
            margin: auto;
            width: 90%;
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

        .slider-background {
            background-image: linear-gradient(to right, #151b2c, rgba(159, 159, 159, 1));
            border-radius: 5px;
            max-height: 4px;
            position: absolute;
            z-index: 1;
            max-width: 808px;
            width: 100%;
            height: 100%;
        }

        .noUi-pips .noUi-value {
            font-size: 15px;
            font-weight: 400;
            line-height: 18.15px;
            text-align: center;
            margin-top: 0;
        }

        .noUi-pips-horizontal {
            width: 102%;
        }

        .noUi-value.highlighted {
            color: rgba(61, 0, 215, 1);
            font-weight: bold;
        }

        .noUi-handle:after, .noUi-handle:before {
            background: none;
        }

        @media (max-width: 990px) {
            .question-single{
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

@include('frontend.content.mock.includes.navbar')

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
                    data-condition-required-response-ids="[{{implode(", ", $question->getRequiredQuestionResponseIds())}}]">
                    @csrf
                    <div class="question mb-5">
                        <div class="question-span-div">
                            <span class="question-span">{{$question->getTitle()}} ({{$question->getInstruction()->getContent()}})</span>
                        </div>
                        <div class="slider-background"></div>
                        <div class="slider" id="slider-{{ $index }}"></div>
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
        const questions = @json(array_map(function ($question) {
        return array_map(function ($response) {
            return $response->getTitle();
        }, $question->getResponses());
    }, $presenter->getQuestions()));

        const sliderValues = {}; // Object to track the slider values by questionId

        questions.forEach((responses, index) => {
            const sliderElement = document.getElementById(`slider-${index}`);
            const questionId = parseInt(sliderElement.closest('.collect-question').dataset.questionId);

            noUiSlider.create(sliderElement, {
                start: [0],
                range: {
                    min: 0,
                    max: responses.length - 1
                },
                connect: 'lower',
                behaviour: 'tap-drag',
                pips: {
                    mode: 'values',
                    values: [...Array(responses.length).keys()],
                    density: 100,
                    format: {
                        to: value => responses[Math.round(value)]
                    }
                }
            });

            sliderValues[questionId] = 0;

            let isSnapping = false;

            // Snapping
            sliderElement.noUiSlider.on('set', function (values, handle) {
                if (isSnapping) return;
                isSnapping = true;
                const snappedValue = Math.round(values[handle]);
                sliderElement.noUiSlider.set(snappedValue);
                sliderValues[questionId] = snappedValue; // Update value for question
                isSnapping = false;
            });

            sliderElement.noUiSlider.on('update', function (values, handle) {
                const answerIndex = Math.round(values[handle]);
                document.querySelectorAll(`#slider-${index} .noUi-value`).forEach((pip, i) => {
                    pip.classList.toggle('highlighted', i === answerIndex);
                });
            });
        });

        const nextButton = document.getElementById('next-button');
        const overlay = document.getElementById('overlay');

        nextButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Generation of json data
            const selectedResponsesFinal = Object.keys(sliderValues).map(questionId => ({
                questionId: parseInt(questionId),
                responses: [sliderValues[questionId]]
            }));

            // console.log(JSON.stringify({ questions: selectedResponsesFinal }, null, 2));

            // Clear old json data, display new
            let jsonOutputDiv = document.getElementById('json-output');
            if (!jsonOutputDiv) {
                jsonOutputDiv = document.createElement('div');
                jsonOutputDiv.id = 'json-output';
                jsonOutputDiv.style.whiteSpace = 'pre-wrap';
                jsonOutputDiv.style.backgroundColor = '#f8f9fa';
                jsonOutputDiv.style.padding = '15px';
                jsonOutputDiv.style.marginTop = '15px';
                jsonOutputDiv.style.border = '1px solid #ced4da';
                jsonOutputDiv.style.borderRadius = '5px';
                nextButton.insertAdjacentElement('afterend', jsonOutputDiv);
            }

            // New json output data
            jsonOutputDiv.textContent = JSON.stringify({ questions: selectedResponsesFinal }, null, 2);

            // Reset the sliders
            Object.keys(sliderValues).forEach(questionId => {
                const sliderElement = document.querySelector(
                    `.collect-question[data-question-id="${questionId}"] .slider`
                );
                sliderElement.noUiSlider.set(0);
                sliderValues[questionId] = 0;
            });
        });
    });
</script>

</body>
</html>
