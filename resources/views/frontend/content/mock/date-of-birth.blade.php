<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date of Birth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f8f8;
            font-family: "Inter Semi Bold", sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .header {
            flex-shrink: 0;
            background-color: #ffffff;
            padding: 3.2rem 3.6rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 3rem;
        }

        .logo img {
            height: 60px;
            object-fit: contain;
        }

        .menu {
            display: flex;
            gap: 4.375rem;
            font-size: 16px;
        }

        .menu a {
            text-decoration: none;
            color: #27343D;
            font-weight: 700;
        }

        .language-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .language-toggle div {
            font-size: 14px;
        }

        .language-toggle .toggle-switch {
            display: inline-block;
            width: 48px;
            height: 24px;
            background-color: #ddd;
            border-radius: 10px;
            position: relative;
            cursor: pointer;
        }

        .language-toggle .toggle-switch:before {
            content: '';
            width: 20px;
            height: 22px;
            background-color: #ffffff;
            border-radius: 50%;
            position: absolute;
            top: 1px;
            left: 1px;
            transition: all 0.3s;
        }

        .language-toggle .toggle-switch.active:before {
            left: 28px;
            background-color: #2c3e50;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .dob-container {
            border-radius: 3rem;
            flex-direction: column;
            margin: 100px auto;
            width: 100%;
            max-width: 62rem;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            box-shadow: 0px 4px 4px 0px #00000040;

        }

        .dob-title {
            font-size: 23px;
            font-weight: 600;
            line-height: 32px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        .choice {

            font-size: 13px;
            font-weight: 400;
            line-height: 25px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        .container {
            width: 52%;
        }

        .btn-primary {
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

            width: 19rem;
            background-color: #151B2C;
            border: none;
            border-radius: 1.7rem;
            box-shadow: 0 4px 4px 0 #00000040;
            min-height: 3.4rem;
        }

        .btn-primary:hover {
            background-color: #34495e;
            transform: scale(1.02);
            transition: transform 0.3s ease-in-out;
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

        .btn-link{
            font-size: 16px;
            font-weight: 700;
            line-height: 19.36px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

            color:#27343D;
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

<div class="header">
    <div class="logo">
        <img src="{{ Vite::asset('resources/images/logo/regain-logo.svg') }}" alt="Regain Logo" class="logo-image">
    </div>
    <div class="menu">
        <a href="#">Regain</a>
        <a href="#">My Regain</a>
        <a href="#">Community</a>
        <a href="#">Help</a>
    </div>
    <div class="language-toggle">
        <div class="language-letters" style="cursor: pointer">UKR | <strong>ENG</strong> | RUS</div>
        <div class="toggle-switch" id="toggle-switch"></div>
    </div>
</div>

<div class="dob-container">
    <a href="#" class="btn btn-link text-decoration-none">&larr; Back</a>
    <div class="container p-5 pt-2">
        <h3 class="text-center mt-0 mb-2 text-nowrap dob-title">What is your date of birth?</h3>
        <p class="text-center text-muted mb-5 choice">Choose one below.</p>
        <form class="mb-0">
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

<script>
    const toggleSwitch = document.getElementById('toggle-switch');
    toggleSwitch.addEventListener('click', function () {
        toggleSwitch.classList.toggle('active');
    });
</script>
</body>
</html>
