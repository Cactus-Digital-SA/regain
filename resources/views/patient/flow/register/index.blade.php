<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regain Register (Patient)</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&display=swap"
        rel="stylesheet">
    @vite(['resources/assets/vendor/fonts/tabler-icons.scss'])
    <style>
        html, body {
            overflow: hidden;
            width: 100%;
        }

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

        .circle-bg {
            overflow: hidden !important;
            position: absolute;
            background-color: transparent;
            border: 3px solid #5C5C5C;
            border-radius: 50%;
            opacity: 1;
            z-index: 1;
            animation-duration: 6s;
            animation-timing-function: ease-in-out;
            animation-iteration-count: infinite;
        }

        /* Circle Animations */
        @keyframes moveUpDown {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5rem);
            }
        }

        @keyframes moveLeftRight {
            0%, 100% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(5rem);
            }
        }

        @keyframes diagonalMove {
            0%, 100% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(5rem, 5rem);
            }
        }

        .circle1 {
            width: 370px;
            height: 370px;
            top: -10rem;
            left: -10rem;
            animation-name: moveUpDown;
        }

        .circle2 {
            width: 370px;
            height: 370px;
            bottom: -15rem;
            right: -10rem;
            animation-name: moveLeftRight;
        }

        .circle3 {
            width: 514px;
            height: 514px;
            top: -10rem;
            right: -8rem;
            animation-name: diagonalMove;
        }

        .circle4 {
            width: 514px;
            height: 514px;
            bottom: -8rem;
            left: 15rem;
            animation-name: moveUpDown;
        }

        header {
            z-index: 2;
            font-size: 14px;
            font-weight: 400;
            padding: 40px 5px;
            line-height: 14px;
            letter-spacing: 1px;
        }

        footer {
            z-index: 2;
            font-size: 14px;
            font-weight: 400;
            padding: 40px 5px;
            line-height: 14px;
            letter-spacing: 1px;
        }

        .content {
            position: relative;
            z-index: 2;
        }

        .hello-text {
            font-family: "Playfair Display", serif;
            font-weight: 600;
            font-size: 50px;
            line-height: 67px;
            letter-spacing: 0;
            text-align: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            scale: 120%;
            margin-top: 4rem;
            z-index: 2;
        }

        .form-group label {
            font-weight: normal;
            float: left;
            color: #fff;
        }

        .form-control {
            border-radius: 25px;
            padding: 15px 15px;
            border: 1px solid #fff;
            background-color: transparent;
            color: #fff;
        }

        .form-control::placeholder {
            color: #c0c0c0;
        }

        .password-field {
            position: relative;
        }

        .eye-icon {
            position: absolute;
            right: 15px;
            top: 55%;
            cursor: pointer;
            color: #c0c0c0;
        }

        .form-check-label {
            color: #c0c0c0;
            cursor: pointer;
            font-weight: 400 !important;
            font-size: 15px;
            margin-top: 0.05rem;
        }

        .form-check {
            display: flex;
            justify-content: normal;
        }

        .btn-custom {
            background-color: #fff;
            color: #333;
            border-radius: 25px;
            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: #e0e0e0;
        }

        .forgot-password {
            font-size: 15px;
            font-weight: 400;
            line-height: 18.15px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            text-decoration: none;
        }

        .popup-text {
            font-size: 15px;
            font-weight: 400;
            line-height: 25px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            width: 85%;
        }

        .forgot-password {
            color: #fff;
            font-size: 0.9rem;
            text-decoration: none;
            margin-top: 2px;
        }

        .forgot-password:hover {
            text-decoration: none;
            color: #c0c0c0;
        }

        .forgot-password-container {
            display: flex;
            justify-content: center;
            margin: 15px;
        }

        .popup {
            display: none;
            position: absolute;
            top: 90%;
            z-index: 1001 !important;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 10px;
            width: 300px;
            text-align: left;
            color: black;
        }

        .popup-content {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #FEFEFE;
        }

        .popup-content a {
            text-align: center;
            text-decoration: none;
        }

        .popup-content a:hover {
            text-decoration: underline;
        }

        .popup-content p {
            text-align: center;
        }

        .close {
            position: absolute;
            top: 0;
            right: 5px;
            font-size: 20px;
            cursor: pointer;
            color: #0c0c0c;
        }

        body > * {
            filter: none;
        }

        input[type="checkbox"] {
            appearance: none;
            width: 0.9rem;
            height: 0.9rem;
            border-radius: 100%;
            position: relative;
            cursor: pointer;
            background-color: transparent;
            border: 1px solid #c0c0c0;
            transition: all 0.3s ease;
        }

        input[type="checkbox"]:hover,
        label.toggle:hover + input[type="checkbox"] {
            border-color: #555;
        }

        input[type="checkbox"]:checked {
            background-color: #c0c0c0;
            border-color: #c0c0c0;
        }

        input[type="checkbox"]:checked {
            background-color: #c0c0c0;
            color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        input[type="checkbox"]:checked {
            background-color: #c0c0c0;
            border-color: #c0c0c0;
        }

        @media (max-width: 1600px) {
            .login-container {
                scale: 115%;
            }
        }

        @media (max-width: 780px) {
            .login-container {
                padding: 2rem;
            }

            .popup {
                top: 78.5%;
            }
        }

        .popup-mask {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            z-index: 200;
        }

        @media (max-width: 450px) {
            .login-container {
                scale: 100%;
            }

            .login-container {
                padding: 1.5rem;
            }

            .popup {
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                position: fixed;
            }

            .forgot-password-container {
                position: unset;
            }

            header {
                padding: 1.5rem;
            }

        }
    </style>
</head>
<body>
<div class="circle-bg circle1"></div>
<div class="circle-bg circle2"></div>
<div class="circle-bg circle3"></div>
<div class="circle-bg circle4"></div>
<header class="d-flex justify-content-end align-items-center position-absolute w-100" style="top: 0; scale: 90%;">
    <div class="language-letters" style="cursor: pointer;">
        <h6 class="mb-0"> UKR | <strong>ENG</strong> | RUS</h6>
    </div>
</header>
<div class="content">
    <div class="hello-container" id="helloContainer" style="opacity: 0; cursor: default; user-select: none; pointer-events: none;">
        <span class="hello-text">Hello!</span>
    </div>
    <div class="regain-logo-container" id="regainLogoContainer" style="display:none; opacity: 0; cursor: default; user-select: none; pointer-events: none;">
        <img src="{{Vite::asset('resources/images/logo/regain-logo-white.svg')}}" alt="Regain Logo" class="regain-logo">
    </div>
    <div class="login-container" id="loginContainer" style="display:none; opacity: 0;">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">User ID</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="your@email.com">
            </div>
            <div class="form-group password-field">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                <span class="eye-icon" onclick="togglePassword()">
                <i class="ti ti-eye"></i>
            </span>
            </div>
            <div class="form-check text-left mb-3">
                <input type="checkbox" class="form-check-input" id="keepLoggedIn">
                <label class="form-check-label ml-1" for="keepLoggedIn">Keep me logged in</label>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Sign In</button>
            <div class="forgot-password-container">
                <a href="#" class="forgot-password" id="forgot-password-link">Forgot your password?</a>
                <div class="popup" id="popup">
                    <div class="popup-content">
                        <span class="close" id="close-popup">&times;</span>
                        <p class="forgot-password" style="color: black !important">Forgot your password?</p>
                        <p class="popup-text">Refer back to your welcome email or <a href="#">click here</a> to resend.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<footer class="d-flex justify-content-end align-items-center position-absolute w-100" style="bottom: 0; scale: 95%;">
    <button type="button" id="btn-next" class="d-flex align-items-center text-white text-decoration-none" style=" border: 2px solid; border-radius: 50%; padding: 5px; width: 50px; height: 50px; background-color: #161B2C !important">
        <i style="font-size: 2.5rem;" class="ti ti-chevron-right"></i>
    </button>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const helloContainer = document.getElementById('helloContainer');
        const regainLogoContainer = document.getElementById('regainLogoContainer');
        const loginContainer = document.querySelector('.login-container');
        const nextButton = document.getElementById('btn-next');
        let nextFlag = false;

        nextButton.addEventListener('click', function (e) {
            nextFlag = true;
            loginContainer.style.transition = 'opacity 2s';
            nextButton.style.transition = 'opacity 2s'
            helloContainer.style.display = 'none';
            regainLogoContainer.style.display = 'none';
            loginContainer.style.display = 'block';
            loginContainer.style.opacity = '0';
            setTimeout(() => {
                loginContainer.style.opacity = '1';
                nextButton.style.opacity = '0';
                nextButton.style.cursor = 'default';

            }, 100);
        });

        if (helloContainer && regainLogoContainer) {
            helloContainer.style.transition = 'opacity 2s';
            regainLogoContainer.style.transition = 'opacity 2s';

            setTimeout(() => {
                helloContainer.style.opacity = 1;
            }, 100);

            setTimeout(() => {
                helloContainer.style.opacity = 0;

                setTimeout(() => {
                    helloContainer.style.display = 'none';

                    if(!nextFlag){
                        regainLogoContainer.style.display = 'block';
                        regainLogoContainer.style.opacity = '0';

                        setTimeout(() => {
                            regainLogoContainer.style.opacity = '1';
                        }, 100);
                    }

                }, 2000);
            }, 3000);
        }
    });

</script>


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
</body>
</html>
