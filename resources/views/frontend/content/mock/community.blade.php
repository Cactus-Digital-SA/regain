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
        background-color: rgba(221, 222, 241, 1) !important;
    }

    .page-title {
        margin-bottom: 90px !important;
    }

    @media (max-width: 1600px) {
        .page-title {
            margin-bottom: 70px !important;
        }
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

    <div class="container-community">
        <div class="col-md-12">
            <h1 class="page-title text-center">Community</h1>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="page-content">
                    <div class="logo-grid">
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/resex_logo.svg') }}" alt="RESEX"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/veterans_logo_blue.svg') }}" alt="MINISTRY OF VETERANS AFFAIRS OF UKRAINE"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/Msf_logo.svg') }}" alt="MEDECINS SANS FRONTIERS"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/Ministry_of_Defence_of_Ukraine_logo.svg') }}" alt="MINISTRY OF DEFENCE OF UKRAINE"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/ministry_health_ukraine.svg') }}" alt="MINISTRY OF HEALTH OF UKRAINE"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/tnrk_logo.svg') }}" alt="TN RK?"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/veteran_hub.svg') }}" alt="VETERAN HUB"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/ohmatdyt_logo.svg') }}" alt="OHMATDYT"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/spirit_logo.svg') }}" alt="SPIRIT"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/recovery_logo.svg') }}" alt="RECOVERY"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/telegram_logo.svg') }}" alt="TELEGRAM"></div></a>
                        <a href="#"><div class="logo-item"><img src="{{ Vite::asset('resources/images/community-logos/lifeline_ukraine.svg') }}" alt="LIFELINE UKRAINE"></div></a>
                    </div>
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
