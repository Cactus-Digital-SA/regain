<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Level 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .question-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: auto;
            width: 100%;
        }

        .dob-container-questions {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 900px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            box-shadow: 0 4px 4px 0 #00000040;
            border-radius: 4rem;
        }

        .question-single {
            width: 100%;
            margin-bottom: 62px;
        }

        .question-span{
            font-size: 16px;
            font-weight: 700;
            line-height: 22px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
        }

        .question-single:last-child {
            margin-bottom: 30px;
        }

        .question-span-div {
            margin-bottom: 10px;
        }

        .slider{
            margin: auto;
            width: 90%;
            z-index: 3;
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
@include('frontend.content.mock.includes.navbar')

<div class="question-wrapper">
    <div class="dob-container-questions">
        <div class="d-flex justify-content-center justify-content-sm-between align-items-center mb-4 text-heading"
             style="width: 100%;">
            <a href="{{ route('mock.question.question-level-3') }}"
               class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle-arrow-left fs-3 me-2"></i> Back
            </a>
            <h3 class="text-center mt-0 mb-0 text-nowrap dob-title">
                Level 4
            </h3>
            <a href="#"
               class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center disabled"
               disabled>
                Next <i class="ti ti-circle-arrow-right fs-3 ms-2"></i>
            </a>
        </div>

        <div class="container px-3 py-2 d-flex justify-content-center align-items-center">
            <form style="width: 100%;">
                @if(isset($questions))
                    @foreach ($questions as $index => $question)
                        <div class="question-single">
                            <div class="question-span-div">
                                <span class="question-span">{{ $question }}</span>
                            </div>
                            <div class="slider-background"></div>
                            <div id="slider-{{ $index }}" class="slider"></div>
                        </div>
                    @endforeach
                @endif
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>
<script>
    @if(isset($questions))
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($questions as $index => $question)
            let slider_{{ $index }} = document.getElementById('slider-{{ $index }}');
            let answers_{{ $index }} = @json($answers[$index]);

            noUiSlider.create(slider_{{ $index }}, {
                start: [0],
                range: {
                    min: 0,
                    max: answers_{{ $index }}.length - 1
                },
                connect: 'lower',
                behaviour: 'tap-drag', // Free movement
                pips: {
                    mode: 'values',
                    values: [...Array(answers_{{ $index }}.length).keys()],
                    density: 100,
                    format: {
                        to: function (value) {
                            return answers_{{ $index }}[Math.round(value)]; // Answer labels
                        }
                    }
                }
            });

            let isSnapping_{{ $index }} = false; // Each slider has a unique flag

            // Snapping
            slider_{{ $index }}.noUiSlider.on('set', function (values, handle) {
                if (isSnapping_{{ $index }}) return; // Recursion protection
                isSnapping_{{ $index }} = true;

                let snappedValue = Math.round(values[handle]);
                slider_{{ $index }}.noUiSlider.set(snappedValue); // Snapping to the closest integer (floats breaks it)

                isSnapping_{{ $index }} = false; // Flag reset
            });



            slider_{{ $index }}.noUiSlider.on('update', function (values, handle) {
                let answerIndex = Math.round(values[handle]);
                document.querySelectorAll(`#slider-{{ $index }} .noUi-value`).forEach((pip, i) => {
                    pip.classList.toggle('highlighted', i === answerIndex);
                });
            });
        @endforeach
    });
    @endif
</script>
</body>
</html>
