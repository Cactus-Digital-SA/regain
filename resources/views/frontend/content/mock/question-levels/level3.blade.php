<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-wrapper {
            scale: 90%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: auto;
            margin-bottom: auto;
        }

        .dob-container-questions {
            display: inline-block;
            border-radius: 4rem;
            flex-direction: column;
            margin: auto;
            min-width: 62rem;
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

        .grid-layout {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap:0;
            justify-items: center;
            align-items: center;
        }

        .grid-layout li {
            list-style: none;
            text-align: center;
        }

        input[type="radio"] {
            display: none;
        }

        label.toggle {
            cursor: pointer;
            background-color: #f0f0f0;
            padding: 5px;
            border: 1px solid rgba(159, 159, 159, 1);
            border-radius: 0;
            font-size: 15px;
            font-weight: 400;
            line-height: 18.15px;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            text-align: center;
            transition: all 0.3s ease;
            width: 160px;
            height: 42px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .grid-layout li:first-child label.toggle {
            border-top-left-radius: 0.4rem;
            border-bottom-left-radius: 0.4rem;
        }

        .grid-layout li:last-child label.toggle {
            border-top-right-radius: 0.4rem;
            border-bottom-right-radius: 0.4rem;
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
            .grid-layout {
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

@include('frontend.content.mock.includes.navbar')

<div class="question-wrapper">
    <div class="dob-container-questions">
        <div class="d-flex justify-content-center justify-content-sm-between align-items-center mb-4 text-heading" style="width: 99%;">
            <a href="{{route('mock.question.question-level-2')}}" class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center"><i class="ti ti-circle-arrow-left fs-3 me-2"></i> Back</a>
            <h3 class="text-center mt-0 mb-0 text-nowrap dob-title">Level 3</h3>
            <a href="{{route('mock.question.question-level-4')}}" class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center">Next <i class="ti ti-circle-arrow-right fs-3 ms-2"></i></a>
        </div>
        <div class="container px-3 py-2 d-flex justify-content-center align-items-center">
            <form>
                @if(isset($questions))
                    @foreach ($questions as $index => $question)
                        <div class="question-single">
                            <span class="question-span"> {{ $question }}</span>
                            <ul class="list-unstyled grid-layout mt-2">
                                @foreach ($answers[$index] as $answerIndex => $answer)
                                    <li>
                                        <input type="radio" id="toggle-location-radio-{{ $index }}-{{ $answerIndex }}"
                                               name="question_{{ $index }}">
                                        <label for="toggle-location-radio-{{ $index }}-{{ $answerIndex }}"
                                               class="toggle">
                                            {{ $answer }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif
            </form>
        </div>
    </div>
</div>
</body>
</html>
