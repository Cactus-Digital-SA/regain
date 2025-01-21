<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regain Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/assets/vendor/fonts/tabler-icons.scss'])
    <style>
        html {
            overflow-y: hidden;
        }
        body {
            background-color: #504E84 !important; /* Darker purple background */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Inter, sans-serif;
            color: #fff;
            background: radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 2vw 15vh / 200px 200px,
            radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 70vw 30vh / 180px 180px,
            radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 80vw 80vh / 400px 400px,
            radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 40vw 90vh / 300px 300px,
            radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 15vw 60vh / 250px 250px,
            radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 95vw 0 / 350px 350px;
            background-repeat: no-repeat;
            overflow-y: auto;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .regain-logo img {
            width: 85%;
            display: block;
            margin: 0 auto 5rem;
        }

        .form-group label {
            font-weight: bold;
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

        .forgot-password-container {
            position: relative;
        }

        .forgot-password{
            color: #fff;
            font-size: 0.9rem;
            text-decoration: none;
            margin-top: 2px ;
        }

        .forgot-password:hover{
            text-decoration: none;
            color: #c0c0c0;
        }

        .forgot-password-container {
            display: flex;
            justify-content: center;
            flex-direction: column;
            margin: 15px;
        }

        .popup {
            display: none;
            position: absolute;
            top: -50%;
            left: 9.5%;
            z-index: 1000;
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
            background-color: #fff;
            transition: all 0.3s ease;
        }

        input[type="checkbox"]:hover,
        label.toggle:hover + input[type="checkbox"] {
            border-color: #555;
        }

        input[type="checkbox"]:checked {
            background-color: #333;
            border-color: #333;
        }

        input[type="checkbox"]:checked {
            background-color: #151B2C;
            color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        input[type="checkbox"]:checked {
            background-color: #333;
            border-color: #333;
        }

        @media (max-width: 1600px) {
            .regain-logo img {
                margin: 0 auto 2.5rem;
            }
        }

        @media (max-width: 990px) {
            body {
                background: radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 2vw 2vh / 200px 200px,
                radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 40vw 90vh / 300px 300px,
                radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 2vw 60vh / 250px 250px,
                radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 90vw 20vh / 350px 350px;
                background-repeat: no-repeat;
                overflow-y: auto;
            }

            .regain-logo img {
                width: 80%;
                margin: 0 auto 2rem;
            }
        }

        .popup-mask {
            display: none; /* Initially hidden */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            z-index: 999; /* Ensure it's above other elements */
        }

        @media (max-width: 450px) {
            .login-container {
                padding: 1.5rem;
            }

            .popup {
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                position: fixed; /* Use fixed positioning for proper centering */
            }

            .forgot-password-container {
                position: unset;
            }

        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="regain-logo">
        <img src="{{ Vite::asset('resources/images/logo/regain-logo-white.svg') }}" alt="Regain Logo">
    </div>
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
            <label class="form-check-label" for="keepLoggedIn">Keep me logged in</label>
        </div>
        <button type="submit" class="btn btn-custom btn-block">Sign In</button>
        <div class="forgot-password-container">
            <a href="#" class="forgot-password" id="forgot-password-link">Forgot your password?</a>
            <div class="popup" id="popup">
                <div class="popup-content">
                    <span class="close" id="close-popup">&times;</span>
                    <p class="forgot-password" style="color: black !important">Forgot your password?</p>
                    <p class="popup-text">Refer back to your welcome email or <a href="#">click here</a> to resend.</p>
                </div>
            </div>
        </div>
    </form>
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
</body>
</html>
