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

        .question-span{
            font-size: 16px;
            font-weight: 700;
            line-height: 22px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        .radio-label{
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
    <div class="d-flex justify-content-between align-items-center" style="width: 99%; margin: 0 auto">
        <a href="#" class="btn btn-link text-decoration-none">&larr; Back</a>
    </div>
    <div class="container px-5 py-2 pb-5">
        <h3 class="text-center mt-0 mb-2 text-nowrap dob-title mb-5">What is your current location?</h3>
        <form>
            @if(isset($questions))
                @foreach ($questions as $index => $question)
                    <div class="question  mb-5">
                        <span class="question-span"> {{ $question }}</span>
                        <ul class="list-unstyled grid-layout mb-4 mt-1">
                            @foreach ($answers[$index] as $answerIndex => $answer)
                                <li>
                                    <input type="radio" id="toggle-location-radio-{{ $index }}-{{ $answerIndex }}" name="question_{{ $index }}"
                                           >
                                    <label for="toggle-location-radio-{{ $index }}-{{ $answerIndex }}" class="toggle">
                                        <span class="radio-label round">{{ $answer }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endif
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mt-3">Next</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
