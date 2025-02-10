<link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">

<div class="header">
    <div class="logo">
        <img src="{{ Vite::asset('resources/images/logo/regain-logo.svg') }}" alt="Regain Logo" class="logo-image">
    </div>
    <div class="menu">
        <a href="{{route('patient.regain-info')}}" style="margin: auto"> Regain</a>
        <a href="{{route('patient.my-regain')}}" style="margin: auto"><i class="ti ti-user-filled"></i> MyRegain</a>
        <a href="{{route('patient.community')}}" style="margin: auto"><i class="ti ti-heart-filled"></i> Community</a>
        <a href="#" style="margin: auto"><i class="ti ti-settings-filled"></i> Settings</a>
        <a href="{{route('patient.help-center')}}" style="margin: auto"><i class="ti ti-question-mark"></i> Help</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none"><i class="ti ti-logout"></i> Logout</button>
        </form>
    </div>
    <div class="language-toggle">
        <div class="language-letters" style="cursor: pointer">UKR | <strong>ENG</strong> | RUS</div>
        <div class="toggle-switch" id="toggle-switch"></div>
    </div>
</div>

<video class="video-background" autoplay muted loop>
    <source
            src="{{asset('assets/moving_balls.mp4') }}"
            type="video/mp4">
    Your browser does not support the video tag.
</video>

@vite(['resources/css/navbar-front.css', 'resources/css/front-main.css'])

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var currentRoute = "{{ Route::currentRouteName() }}"; // Used for certain pages that might not have the video background

        const toggleSwitch = document.getElementById('toggle-switch');
        const videoBackground = document.querySelector('.video-background');
        const circleBgs = document.querySelectorAll('.circle-bg');

        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = "expires=" + date.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const decodedCookie = decodeURIComponent(document.cookie);
            const cookieArray = decodedCookie.split(';');
            for (let i = 0; i < cookieArray.length; i++) {
                let cookie = cookieArray[i];
                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1);
                }
                if (cookie.indexOf(nameEQ) === 0) {
                    return cookie.substring(nameEQ.length, cookie.length);
                }
            }
            return null;
        }

        const savedState = getCookie('toggleSwitchState');
        let isActive = savedState === 'true';

        if (isActive) {
            toggleSwitch.classList.add('active');
            videoBackground.classList.remove('d-none');
            videoBackground.play();
            circleBgs.forEach(circleBg => circleBg.classList.add('d-none'));
        } else {
            toggleSwitch.classList.remove('active');
            videoBackground.pause();
            videoBackground.classList.add('d-none');
            circleBgs.forEach(circleBg => circleBg.classList.remove('d-none'));
        }

        let interval = null;

        function smoothPause() {
            if (videoBackground.playbackRate > 0.5) {
                videoBackground.playbackRate -= 0.5;
            } else {
                videoBackground.playbackRate = 1.0;
                videoBackground.pause();
                clearInterval(interval);

                circleBgs.forEach(circleBg => circleBg.classList.remove('d-none'));
                videoBackground.classList.add('d-none');
            }
        }

        function smoothPlay() {
            if (videoBackground.playbackRate < 1.0) {
                videoBackground.playbackRate += 0.5;
            } else {
                videoBackground.playbackRate = 1.0;
                videoBackground.play();
                clearInterval(interval);

                circleBgs.forEach(circleBg => circleBg.classList.add('d-none'));
                videoBackground.classList.remove('d-none');
            }
        }

        toggleSwitch.addEventListener('click', function () {
            toggleSwitch.classList.toggle('active');
            isActive = !isActive;

            setCookie('toggleSwitchState', isActive, 7);

            clearInterval(interval);
            if (isActive) {
                videoBackground.play();
                videoBackground.playbackRate = 0.5;
                interval = setInterval(smoothPlay, 50);
            } else {
                interval = setInterval(smoothPause, 50);
            }
        });
    });
</script>



