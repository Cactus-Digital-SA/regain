<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .question-single {
            width: 100%;
            margin-bottom: 40px;
        }

        .slider-container {
            width: 100%;
            position: relative;
            margin-top: 20px;
        }

        .slider {
            width: 100%;
            appearance: none;
            height: 8px;
            background: #ddd;
            outline: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .slider::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            background: #151B2C;
            border-radius: 50%;
            cursor: pointer;
        }

        .answers {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            width: 100%;
        }

        .answer {
            text-align: center;
            font-size: 15px;
            font-weight: 400;
            flex: 1;
        }

        .answer.selected {
            font-weight: 700;
            color: #151B2C;
        }
    </style>
</head>
<body>

@include('frontend.content.mock.includes.navbar')

<div class="question-wrapper">
    <div class="dob-container-questions">
        <div class="d-flex justify-content-center justify-content-sm-between align-items-center mb-4 text-heading" style="width: 100%;">
            <a href="#" class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center"><i class="ti ti-circle-arrow-left fs-3 me-2"></i> Back</a>
            <h3 class="text-center mt-0 mb-0 text-nowrap dob-title">Level 4</h3>
            <a href="#" class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center">Next <i class="ti ti-circle-arrow-right fs-3 ms-2"></i></a>
        </div>
        <div class="container px-3 py-2 d-flex justify-content-center align-items-center">
            <form style="width: 100%;">
                @if(isset($questions))
                    @foreach ($questions as $index => $question)
                        <div class="question-single">
                            <span class="question-span">{{ $question }}</span>
                            <div class="slider-container">
                                <input type="range" class="slider" id="slider-{{ $index }}" min="0" max="100" value="0" oninput="updateAnswer(this, {{ $index }}, {{ count($answers[$index]) }})">
                                <div class="answers">
                                    @foreach ($answers[$index] as $answerIndex => $answer)
                                        <div class="answer" id="answer-{{ $index }}-{{ $answerIndex }}">{{ $answer }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    function updateAnswer(slider, questionIndex, answerCount) {
        const sliderValue = slider.value;
        const selectedAnswerIndex = Math.round((sliderValue / 100) * (answerCount - 1));
        const answers = document.querySelectorAll(`#answer-${questionIndex}-\\3`);

        answers.forEach((answer, index) => {
            answer.classList.remove('selected');
            if (index === selectedAnswerIndex) {
                answer.classList.add('selected');
            }
        });
    }
</script>

</body>
</html>
