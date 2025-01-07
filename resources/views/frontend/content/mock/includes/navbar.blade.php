<div class="header">
    <div class="logo">
        <img src="{{ Vite::asset('resources/images/logo/regain-logo.svg') }}" alt="Regain Logo" class="logo-image">
    </div>
    <div class="menu">
        <a href="{{route('mock.regain-info')}}">Regain</a>
        <a href="#"><i class="ti ti-user"></i> MyRegain</a>
        <a href="#"><i class="ti ti-heart"></i> Community</a>
        <a href="#"><i class="ti ti-settings"></i> Settings</a>
        <a href="#"><i class="ti ti-question-mark"></i> Help</a>
        <a href="#"><i class="ti ti-question-logout"></i> Logout</a>
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
        var currentRoute = "{{ Route::currentRouteName() }}";


        console.log(currentRoute);
        const toggleSwitch = document.getElementById('toggle-switch');
        const videoBackground = document.querySelector('.video-background');
        let isActive = false;
        let interval = null;

        function smoothPause() {
            if (videoBackground.playbackRate > 0.5) {
                videoBackground.playbackRate -= 0.5;
            } else {
                videoBackground.playbackRate = 1.0;
                videoBackground.pause();
                clearInterval(interval);

                if(currentRoute === 'mock.regain-info'){
                    videoBackground.classList.add('d-none');
                }

            }
        }

        function smoothPlay() {
            if (videoBackground.playbackRate < 1.0) {
                videoBackground.playbackRate += 0.5;
            } else {
                videoBackground.playbackRate = 1.0;
                videoBackground.play();
                clearInterval(interval);

                videoBackground.classList.remove('d-none');
            }
        }

        toggleSwitch.addEventListener('click', function () {
            toggleSwitch.classList.toggle('active');
            isActive = !isActive;

            clearInterval(interval);
            if (isActive) {
                interval = setInterval(smoothPause, 50);
            } else {
                videoBackground.play();
                videoBackground.playbackRate = 0.5;
                interval = setInterval(smoothPlay, 50);
            }
        });
    })
</script>



