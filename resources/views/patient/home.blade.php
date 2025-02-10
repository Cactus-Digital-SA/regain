@php
    /**
     * @var bool $back
     */
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Regain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css" rel="stylesheet">
    <style>

        body {
            overflow-y: hidden;
        }

        .welcome-back-title {
            font-weight: 600;
            font-size: 23px;
            line-height: 32px;
            letter-spacing: 0;
            text-align: center;
        }

        .dob-container-questions {
            max-width: 900px !important;
            width: 100%;
            text-align: center;
            margin: auto !important;
        }

        .container-inside {
            text-align: left;
        }

        .list-unstyled li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .list-unstyled li::before {
            content: "⬢"; /* Icon placeholder */
            font-size: 18px;
            color: black;
        }

        .btn-next {
            background-color: black;
            border-radius: 20px;
            padding: 10px 30px;
            font-size: 16px;
            min-width: 320px !important;
            width: 100%;
        }

        .container {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        @media screen and (max-width: 1600px) {
            body {
                overflow-y: hidden;
            }

            .container {
                padding-top: 5px;
                padding-bottom: 5px;
            }
        }
    </style>
</head>
<body>

@vite(['resources/css/patient-index.css'])

@include('patient.includes.navbar')

<div class="dob-container-questions">
    <div class="container px-5">
        @if(isset($register) && $register)
            <h3 class="text-center pt-0 my-0 welcome-back-title">Welcome to Regain!</h3>
        @else
            <h3 class="text-center pt-0 my-0 welcome-back-title">Welcome
                @if ($back)
                Back
                @endif
                to Regain!</h3>
        @endif
        <div class="container-inside m-5 text-start d-flex justify-content-center">
            <ul class="list-unstyled d-flex justify-content-center">
                <div class="d-flex justify-content-center flex-column gap-3">
                    <div class="list-item">
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-1">
                                    <img src="{{ Vite::asset('resources/images/home-icon-questions/home.svg') }}" alt="">
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <strong class="list-item-title">Regain</strong>
                                    <span class="list-item-text">Information about Regain</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-1">
                                    <img src="{{ Vite::asset('resources/images/home-icon-questions/home.svg') }}" alt="">
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <strong class="list-item-title">My Regain</strong>
                                    <span class="list-item-text">Manage your profile, progress, and appointments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-1">
                                    <img src="{{ Vite::asset('resources/images/home-icon-questions/home.svg') }}" alt="">
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <strong class="list-item-title">Settings</strong>
                                    <span class="list-item-text">Accessibility options</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-1">
                                    <img src="{{ Vite::asset('resources/images/home-icon-questions/home.svg') }}" alt="">
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <strong class="list-item-title">Help</strong>
                                    <span class="list-item-text">Change language, FAQ, updates, report issues</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-1">
                                    <img src="{{ Vite::asset('resources/images/home-icon-questions/home.svg') }}" alt="">
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <strong class="list-item-title">Live Chat</strong>
                                    <span class="list-item-text">Say hello to reBot - always online for you!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{route('patient.ask')}}" type="button" class="btn btn-primary btn-next d-flex align-items-center justify-content-center">Next</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/67a3c0203a842732607a2e2e/1ijbqd090';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
</body>
</html>
