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
            overflow: hidden;
        }

        .circle-bg {
            position: absolute;
            border-radius: 50%;
            overflow: hidden;
            background-color: #F5F5F5;
            opacity: 1;
            z-index: 1;
        }

        .circle1 {
            width: 370px;
            height: 370px;
            top: -10rem;
            left: -10rem;
        }

        .circle2 {
            width: 370px;
            height: 370px;
            bottom: -15rem;
            right: -10rem;
        }

        .circle3 {
            width: 230px;
            height: 230px;
            top: 10rem;
            right: -8rem;
        }

        .circle3 {
            width: 230px;
            height: 230px;
            bottom: 10rem;
            right: -8rem;
        }


    </style>
</head>
<body>
@include('frontend.content.mock.includes.navbar')
<div class="circle-bg circle1"></div>
<div class="circle-bg circle2"></div>
<div class="circle-bg circle3"></div>
<div class="circle-bg circle4"></div>

</body>
</html>
