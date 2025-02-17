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

        header{
            position: absolute;
            top: 0;
            width: 100%;
            font-size: 14px;
            font-weight: 400;
            padding: 40px 60px;
            line-height: 14px;
            letter-spacing: 1px;
        }

        .welcome-back-container {
            width: 80%;
            margin-top: auto;
            margin-bottom: auto;
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
            align-items: center;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background-color: #F1EDE9;
            z-index: 0;
            contain: content;
        }

        .circle-video video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%; /* Ensures the video respects the circular shape */
        }

        .welcome-back-container {
            position: relative;
            z-index: 1;
        }

        .form-group label {
            font-weight: normal;
            float: left;
            color: #fff;
        }

        body > * {
            filter: none;
        }

        @media (max-width: 1600px){
            .circle-video {
                width: 550px;
                height: 550px;
            }

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
<header>
    <div class="d-flex justify-content-between">
        <div>
            <strong>
            </strong>
        </div>
        <div>
            <div class="language-letters" style="cursor: pointer;">
                <span> UKR | <strong>ENG</strong> | RUS</span>
            </div>
        </div>
    </div>
</header>
<div class="welcome-back-container">
    <div class="row">
        <div class="d-flex justify-content-center align-items-center col-12 col-xl-6">
            <div class="row">
                <div class="d-flex justify-content-center align-items-center col-12">
                    <div class="row">
                        <div class="col-md-12 word-container">
                            <div class="col-md-12 d-flex justify-content-center align-items-center">
                                <img src="{{Vite::asset('resources/images/logo/regain-logo-white.svg')}}" alt="Logo"
                                     class="w-75">
                            </div>
                            <h1 class="text-center welcome-back-text mt-4 py-5 text-nowrap">Welcome Back!</h1>
                        </div>
                        <div class="col-12 px-2 d-flex justify-content-center align-items-center">
                            <a href="{{ route('patient-flow.login-old') }}" type="button" class="btn btn-custom-start btn-block p-2">Start</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="circle-video">
                <video width="100%" height="100%" autoplay loop muted playsinline>
                    <source src="{{ asset('assets/main_video.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.querySelector('.eye-icon i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('ti-eye');
            eyeIcon.classList.add('ti-eye-off');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('ti-eye-off');
            eyeIcon.classList.add('ti-eye');
        }
    }

    const popupMask = document.createElement('div');
    popupMask.classList.add('popup-mask');
    document.body.appendChild(popupMask);
    const forgotPasswordLink = document.getElementById('forgot-password-link');
    const closePopup = document.getElementById('close-popup')

    forgotPasswordLink.addEventListener('click', (e) => {
        e.preventDefault();
        popup.style.display = 'flex';
        if (window.innerWidth <= 450) {
            popupMask.style.display = 'block';
        }
    });

    closePopup.addEventListener('click', () => {
        popup.style.display = 'none';
        popupMask.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === popup) {
            popup.style.display = 'none';
            popupMask.style.display = 'none';
        }
    });

    function toggleMaskOnResize() { //extra check to show the mask on window resize
        if (popup.style.display === 'flex') {
            if (window.innerWidth <= 450) {
                popupMask.style.display = 'block'
            } else {
                popupMask.style.display = 'none';
            }
        }
    }

    window.addEventListener('resize', toggleMaskOnResize);
</script>
<script>
    setInterval(() => {
        fetch('/refresh-csrf').then(response => response.json()).then(data => {
            document.querySelector('input[name="_token"]').value = data.token;
        });
    }, 120000); // Refresh every 5 minutes
</script>
</body>
</html>
