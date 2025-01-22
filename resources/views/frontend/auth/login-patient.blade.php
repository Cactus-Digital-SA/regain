<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regain Login (Patient)</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/assets/vendor/fonts/tabler-icons.scss'])
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
            font-size: 14px;
            font-weight: 400;
            padding: 40px 5px;
            line-height: 14px;
            letter-spacing: 1px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            scale: 120%;
            margin-top: 4rem;
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

        .form-check{
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
            margin: 15px;
        }

        .popup {
            display: none;
            position: absolute;
            top: 85%;
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
<header class="d-flex justify-content-between align-items-center position-absolute w-100" style="top: 0; scale: 90%;">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none" style="gap: 10px;">
        <span class="d-flex justify-content-center align-items-center"
              style="border: 2px solid; border-radius: 50%; padding: 5px; width: 24px; height: 24px;">
            <i class="ti ti-chevron-left"></i>
        </span>
        <span class="ms-2">Back</span>
    </a>

    <div class="language-letters" style="cursor: pointer;">
        <h6 class="mb-0"> UKR | <strong>ENG</strong> | RUS</h6>
    </div>
</header>
<div class="login-container">
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
