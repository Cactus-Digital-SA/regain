<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E8F0E6 !important;
            height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        .background-circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow-x: hidden;
        }

        .circle-bg {
            position: absolute;
            border-radius: 50%;
            background-color: #F5F5F5;
            opacity: 1;
            z-index: -1;
        }

        .circle1 {
            width: 20vw;
            height: 20vw;
            top: -10vw;
            left: -10vw;
        }

        .circle2 {
            width: 25vw;
            height: 25vw;
            bottom: -15vw;
            right: -10vw;
        }

        .circle3 {
            width: 15vw;
            height: 15vw;
            top: 15vh;
            right: -5vw;
        }

        .circle4 {
            width: 15vw;
            height: 15vw;
            bottom: 10vh;
            left: -5vw;
        }

        .wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .container {
            position: relative;
            z-index: 2;
            padding: 1rem;
            max-width: 690px;
        }

        .page-title {
            font-size: 1.625rem;
            font-weight: 700;
            line-height: 25px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            margin-bottom: 50px;
        }

        .page-sub-title {
            font-size: 1.125rem;
            font-weight: 700;
            line-height: 20px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
        }

        .page-content p {
            font-size: 0.95rem;
            font-weight: 400;
            line-height: 25px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        .footer button {
            font-size: 0.8rem;
            font-weight: 400;
            text-align: left;
            text-decoration-line: underline;
            text-decoration-style: solid;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        @media (max-width: 1600px) {
            .page-title {
                margin-bottom: 30px;
            }
        }

    </style>
</head>
<body>
@include('frontend.content.mock.includes.navbar')
<div class="background-circles">
    <div class="circle-bg circle1"></div>
    <div class="circle-bg circle2"></div>
    <div class="circle-bg circle3"></div>
    <div class="circle-bg circle4"></div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center">Regain</h1>
            </div>
            <div class="col-md-12 mt-2">
                <div class="page-content">
                    <h3 class="page-sub-title">About Us</h3>
                    <p>
                        We are working on ways to use AI to revolutionise the field of mental health treatment and
                        subsequent rehabilitation, including addressing mental health disorders that are often resistant
                        to
                        traditional treatments, such as PTSD, depression, and anxiety.
                        <br>
                        <br>
                        The interdisciplinary team behind Regain includes academics and professors from the UK and the
                        EU
                        working within developmental psychology and human behaviour alongside scientists, experienced
                        clinical psychologists and psychiatrists who specialise in PTSD, trauma management and
                        addressing
                        mental health disorders. The team are supported by content creators, bioinformaticians, AI
                        specialists and mathematicians alongside strategists versed in implementing healthcare solutions
                        including large scale community screening programmes.
                    </p>
                    <h3 class="page-sub-title mt-4">Contact</h3>
                    <p class="">
                        Regain™<br>
                        Becket House, 36 Old Jewry London, EC2R 8DD<br>
                        Registered in Greece: GEMI 160675506000
                    </p>
                    <p class="text-decoration-underline">info@regain.world</p>
                </div>
            </div>
        </div>
    </div>
    <div style="position: absolute; bottom: 0; width: 100%;" class="footer text-center mb-1">
        <button type="button" class="btn btn-link">Privacy Settings</button>
        <button type="button" class="btn btn-link">Privacy Policy</button>
    </div>
</div>
</body>
</html>
