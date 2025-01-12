<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background-color: #E8F0E6 !important;
    }
</style>
<body>
@include('frontend.content.mock.includes.navbar')
@vite(['resources/css/help-info-pages.css'])
<div class="background-circles">
    <div class="circle-bg circle1"></div>
    <div class="circle-bg circle2"></div>
    <div class="circle-bg circle3"></div>
    <div class="circle-bg circle4"></div>
</div>
<div class="basic-wrapper">
    <div class="container-info">
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
</div>
<div class="footer text-center mb-1">
    <button type="button" class="btn btn-link">Privacy Settings</button>
    <button type="button" class="btn btn-link">Privacy Policy</button>
</div>
</body>
</html>
