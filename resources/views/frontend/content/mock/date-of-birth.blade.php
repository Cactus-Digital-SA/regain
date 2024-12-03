<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            width: 52%;
        }

        .dropdown-select {
            cursor: pointer;
            font-size: 16px;
            font-weight: 300;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

            border-radius: 1.7rem;
            display: flex;
            box-shadow: 0 4px 4px 0 #00000040;
            padding: 10px;
            border: 1px solid #000; /* black like pencil */
            width: 100%;
            min-height: 3.4rem;
            height: 100%;
            margin-bottom: 1.25rem;
            appearance: none;
            background: #fff url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"><path fill="none" stroke="%23999" stroke-width="1.5" d="M1 7.5l7 7 7-7"/></svg>') no-repeat right 25px center/15px;
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
    <a href="#" class="btn btn-link text-decoration-none">&larr; Back</a>
    <div class="container p-5 pt-2">
        <h3 class="text-center mt-0 mb-2 text-nowrap dob-title">What is your date of birth?</h3>
        <p class="text-center text-muted mb-5 choice">Choose one below.</p>
        <form class="mb-0" onsubmit="return false;">
            <select class="dropdown-select" name="day">
                <option value="">Day</option>
                @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <select class="dropdown-select" name="month">
                <option value="">Month</option>
                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                    <option value="{{ $month }}">{{ $month }}</option>
                @endforeach
            </select>
            <select class="dropdown-select mb-5" name="year">
                <option value="">Year</option>
                @for ($i = date('Y'); $i >= 1900; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-primary w-100 mt-3">Next</button>
        </form>
    </div>
</div>


</body>
</html>
