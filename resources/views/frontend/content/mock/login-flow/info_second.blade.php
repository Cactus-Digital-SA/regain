<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regain Info 2</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
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

        .info-container {
            width: 100%;
            max-width: 490px;
            scale: 110%;
            margin-top: 4rem;
        }

        .btn-custom-next {
            background-color: #F1EDE9;
            color: #161B2C;
            border-radius: 25px;
            font-size: 18px;
            font-weight: 400;
            text-align: center;
        }

        .btn-custom-next:hover {
            background-color: #e0e0e0;
        }

        .btn-custom-prev {
            background-color: transparent;
            color: #F1EDE9;
            border: 1px solid #F1EDE9;
            border-radius: 25px;
            font-size: 18px;
            font-weight: 400;
            text-align: center;
        }

        .btn-custom-prev:hover {
            background-color: rgba(224, 224, 224, 0.1);
            color: #fff;
        }

        .list-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
        }

        .list-item-text {
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            text-wrap: nowrap;
        }

        .list-item-title {
            font-size: 16px;
            font-weight: 400;
            line-height: 26px;
            text-align: justify;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        body > * {
            filter: none;
        }

        @media (max-width: 1600px) {
            .info-container {
                scale: 115%;
            }
        }

        @media (max-width: 780px) {
            .info-container {
                padding: 2rem;
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
<div class="info-container">
    <div class="row mb-5">
        <div class="col-md-12 word-container">
            <p>It is a requirement that all individuals utilising the <strong>Regain</strong>&#8482
                platform be referred.</p>
            <div class="col-md-11 d-flex justify-content-center flex-column">
                <div class="list-item">
                    <img src="{{ Vite::asset('resources/images/circle-icons/circle-question-mark.svg') }}" alt="" class="mr-2">
                    <div class="d-flex flex-column">
                        <strong class="list-item-title">Help</strong>
                        <span class="list-item-text">It is a requirement that all individuals utilising the Regain platform be referred.</span>
                    </div>
                </div>
                <div class="list-item">
                    <img src="{{ Vite::asset('resources/images/circle-icons/circle-r.svg') }}" alt="" class="mr-2">
                    <div class="d-flex flex-column">
                        <strong class="list-item-title">Regain</strong>
                        <span class="list-item-text">Information about Regain</span>
                    </div>
                </div>
                <div class="list-item">
                    <img src="{{ Vite::asset('resources/images/circle-icons/circle-user.svg') }}" alt="" class="mr-2">
                    <div class="d-flex flex-column">
                        <strong class="list-item-title">My Regain</strong>
                        <span class="list-item-text">It is a requirement that all individuals utilising the Regain platform be referred.</span>
                    </div>
                </div>
                <div class="list-item">
                    <img src="{{ Vite::asset('resources/images/circle-icons/circle-community.svg') }}" alt="" class="mr-2">
                    <div class="d-flex flex-column">
                        <strong class="list-item-title">Community</strong>
                        <span class="list-item-text">It is a requirement that all individuals utilising the Regain platform be referred.</span>
                    </div>
                </div>
                <div class="list-item">
                    <img src="{{ Vite::asset('resources/images/circle-icons/circle-info.svg') }}" alt="" class="mr-2">
                    <div class="d-flex flex-column">
                        <strong class="list-item-title">Info</strong>
                        <span class="list-item-text">It is a requirement that all individuals utilising the Regain platform be referred.</span>
                    </div>
                </div>
                <div class="list-item">
                    <img src="{{ Vite::asset('resources/images/circle-icons/circle-chat.svg') }}" alt="" class="mr-2">
                    <div class="d-flex flex-column">
                        <strong class="list-item-title">Live Chat</strong>
                        <span class="list-item-text">It is a requirement that all individuals utilising the Regain platform be referred.</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 px-2">
            <button type="button" class="btn btn-custom-prev btn-block">Previous</button>
        </div>
        <div class="col-6 px-2">
            <button type="button" class="btn btn-custom-next btn-block">Next</button>
        </div>
    </div>
</div>
</body>
</html>
