<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta
        name="viewport"
        content="width=device-width,initial-scale=1.0"
    />
    <title>Level 4</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
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

        .dob-container-questions{
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 900px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            box-shadow: 0 4px 4px 0 #00000040;
            border-radius: 4rem;}

        .question-single {
            width: 100%;
            margin-bottom: 40px;
        }

        .slider-container{
            width: 100%;
            position: relative;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .slider{
            width: 700px;
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
            background-color: #fff;
            border: 3px solid #151b2c;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s ease;
        }


        .answers {
            position: relative;
            height: 30px;
            width: 700px;
            margin-top: 10px;
        }

        .answer{
            position: absolute;
            top: 0;
            transform: translateX(-50%);
            font-size: 15px;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            transition: color 0.2s, background-color 0.2s;
        }

        .highlighted {
            color: rgba(61, 0, 215, 1);
            border-radius: 10px;
        }
    </style>
</head>
<body>
@include('frontend.content.mock.includes.navbar')

<div class="question-wrapper">
    <div class="dob-container-questions">
        <div
            class="d-flex justify-content-center justify-content-sm-between align-items-center mb-4 text-heading"
            style="width: 100%;"
        >
            <a
                href="{{ route('mock.question.question-level-3') }}"
                class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center"
            >
                <i class="ti ti-circle-arrow-left fs-3 me-2"></i> Back
            </a>
            <h3 class="text-center mt-0 mb-0 text-nowrap dob-title">
                Level 4
            </h3>
            <a
                href="#"
                class="btn btn-link text-decoration-none fs-6 d-flex align-items-center justify-content-center disabled"
                disabled
            >
                Next <i class="ti ti-circle-arrow-right fs-3 ms-2"></i>
            </a>
        </div>

        <div
            class="container px-3 py-2 d-flex justify-content-center align-items-center"
        >
            <form style="width: 100%;">
                @if(isset($questions))
                    @foreach ($questions as $index => $question)
                        <div class="question-single">
                            <span class="question-span">{{ $question }}</span>
                            <div class="slider-container" >
                                <div class="slider-background" style="z-index:1; position: absolute; top: 0; width: 800px; height: 8px; background-color: #ddd; border-radius: 5px;"></div>
                                    <input style="z-index:1;"
                                        type="range"
                                        class="slider"
                                        id="slider-{{ $index }}"
                                        min="0"
                                        max="100"
                                        value="0"
                                        oninput="updateAnswer(this, {{ $index }}, {{ count($answers[$index]) }})"
                                        onmouseup="snapToClosestAnswer(this, {{ $index }}, {{ count($answers[$index]) }})"
                                        ontouchend="snapToClosestAnswer(this, {{ $index }}, {{ count($answers[$index]) }})"
                                    />
                                <div class="answers">
                                    @foreach ($answers[$index] as $answerIndex => $answer)
                                        <div
                                            class="answer"
                                            id="answer-{{ $index }}-{{ $answerIndex }}"
                                            style="left: calc((700px / ({{ count($answers[$index]) - 1 }})) * {{ $answerIndex }});"
                                        >
                                            {{ $answer }}
                                        </div>
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
    function snapToClosestAnswer(slider, questionIndex, totalAnswers) {
        let value = parseInt(slider.value);
        let stepSize = 100 / (totalAnswers - 1);
        let snappedIndex = Math.round(value / stepSize);

        let current = parseFloat(slider.value);
        let target = snappedIndex * stepSize;
        let step = (target - current) / 5;

        function animateSnap() {
            current += step;
            if (Math.abs(target - current) < Math.abs(step)) {
                slider.value = target;
                console.log(current);

                highlightAnswer(questionIndex, snappedIndex, totalAnswers);
            } else {
                slider.value = current;
                console.log(current);
                requestAnimationFrame(animateSnap);
            }
        }

        animateSnap();
    }

    function highlightAnswer(questionIndex, answerIndex, totalAnswers) {
        for (let i = 0; i < totalAnswers; i++) {
            document
                .getElementById('answer-' + questionIndex + '-' + i)
                .classList.remove('highlighted');
        }
        document
            .getElementById('answer-' + questionIndex + '-' + answerIndex)
            .classList.add('highlighted');
    }
</script>
</body>
</html>
