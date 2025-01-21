<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regain Welcome Back</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/assets/vendor/fonts/tabler-icons.scss'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #161B2C !important;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Inter, sans-serif;
            color: #fff;
            overflow: hidden;
        }

        .welcome-back-container {
            width: 80%;
            margin-top: 4rem;
        }

        .welcome-back-text {
            font-family: "Playfair Display", serif;
            font-size: 50px;
            font-weight: 600;
            line-height: 50px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
        }

        .btn-custom-start {
            background-color: #F1EDE9;
            color: #161B2C;
            border-radius: 30px;
            font-size: 23px;
            font-weight: 500;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            width: 70%;

        }

        .btn-custom-start:hover {
            background-color: #e0e0e0;
        }

        .circle-video {
            position: relative;
            display: flex;
            justify-content: center;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background-color: #F1EDE9;
            z-index: 0;
        }

        .welcome-back-container {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 1400px){
            .circle-video {
                width: 440px;
                height: 440px;
            }
        }

        @media (max-width: 1200px) {
            .welcome-back-container {
                padding: 2rem;
            }

            .circle-video {
                display: none;
            }
        }
    </style>
</head>
<body>
<header class="d-flex justify-content-end align-items-center p-5 position-absolute w-100" style="top: 0;">
    <div class="language-letters" style="cursor: pointer;">
        <h6> UKR | <strong>ENG</strong> | RUS</h6>
    </div>
</header>
<div class="welcome-back-container">
    <div class="row">
        <div class="d-flex justify-content-center align-items-center col-12 col-xl-6">
            <div class="row">
                <div class="col-md-12 word-container">
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <img src="{{Vite::asset('resources/images/logo/regain-logo-white.svg')}}" alt="Logo"
                             class="w-75">
                    </div>
                    <h1 class="text-center welcome-back-text mt-4 py-5 text-nowrap">Welcome Back!</h1>
                </div>
                <div class="col-12 px-2 d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-custom-start btn-block p-2">Start</button>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="circle-video">
                <video width="100%" height="100%" autoplay muted loop></video>
            </div>
        </div>
    </div>
</div>
</body>
</html>
