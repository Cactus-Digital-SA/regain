<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-wrapper{
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

        @media (max-width: 990px) {
            .question-wrapper{
                scale: 100%;
                max-width: unset;
            }

            .dob-container-questions{
                min-width: unset;
                margin: 2rem;
            }
        }

        @media (max-width: 480px) {
            .dob-container-questions{
                margin: auto;
            }

            .text-heading > a{
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
            <a href="#" class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center disabled" disabled><i class="ti ti-circle-arrow-left fs-3 me-2"></i> Back</a>
            <h3 class="text-center mt-0 mb-0 text-nowrap dob-title">Level 1</h3>
            <a href="{{route('mock.question.question-level-2')}}" class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center">Next <i class="ti ti-circle-arrow-right fs-3 ms-2"></i></a>
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
                                               name="question_{{ $index }}"
                                        >
                                        <label for="toggle-location-radio-{{ $index }}-{{ $answerIndex }}"
                                               class="toggle">
                                            <span class="radio-label round">{{ $answer }}</span>
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
