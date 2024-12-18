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
        body {
            background-color: #504E84 !important; /* Darker purple background */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            color: #fff;
            background:
                radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 2vw 15vh / 200px 200px,
                radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 70vw 30vh / 180px 180px,
                radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 80vw 80vh / 400px 400px,
                radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 40vw 90vh / 300px 300px,
                radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 15vw 60vh / 250px 250px,
                radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 95vw 0 / 350px 350px;
            background-repeat:no-repeat;
            overflow-y: auto;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
        }
        .regain-logo img {
            width: 85%; /* Adjusted logo size */
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
            top: 53%;
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
        .forgot-password a {
            color: #c0c0c0;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
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

       @media (max-width: 780px){
           body {
               background:
                   radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 2vw 2vh / 200px 200px,
                   radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 40vw 90vh / 300px 300px,
                   radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 2vw 60vh / 250px 250px,
                   radial-gradient(farthest-side, rgba(255, 255, 255, 0.3) 32%, rgba(255, 255, 255, 0.2) 90%, rgba(255, 255, 255, 0.2) 93%, rgba(255, 255, 255, 0.2) 96%, transparent) 90vw 20vh / 350px 350px;
               background-repeat:no-repeat;
               overflow-y: auto;
           }
           .login-container{
               padding: 2rem;
           }
       }
    </style>
</head>
<body>
<div class="login-container">
    <div class="regain-logo">
        <img src="{{ Vite::asset('resources/images/logo/regain-logo-white.svg') }}" alt="Regain Logo">
    </div>
    <form>
        <div class="form-group">
            <label for="userID">User ID</label>
            <input type="text" class="form-control" id="userID" placeholder="user814339ID">
        </div>
        <div class="form-group password-field">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password"
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
        <div class="forgot-password mt-3 text-center">
            <a href="#">Forgot your password?</a>
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
</script>
</body>
</html>
