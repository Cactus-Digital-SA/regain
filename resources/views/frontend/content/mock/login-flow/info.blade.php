<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regain Info</title>
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

        .info-container {
            width: 100%;
            max-width: 490px;
            scale: 125%;
            margin-top: 4rem;
        }

        .btn-custom-next {
            background-color: #F1EDE9;
            color: #161B2C;
            border-radius: 25px;
            font-size: 18px;
            font-weight: 400;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        .btn-custom-next:hover {
            background-color: #e0e0e0;
        }

        .btn-custom-prev {
            background-color: transparent;
            color: #F1EDE9;
            border: 1px solid #F1EDE9;
            border-radius: 25px;
            font-size: 18px;
            font-weight: 400;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
        }

        .btn-custom-prev:hover {
            background-color: rgba(224, 224, 224, 0.1);
            color: #fff;
        }

        .word-container p {
            font-size: 16px;
            font-weight: 400;
            line-height: 26px;
            text-align: justify;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        body > * {
            filter: none;
        }

        @media (max-width: 1600px) {
            .info-container {
                scale: 115%;
            }
        }

        @media (max-width: 780px) {
            .info-container {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
<header class="d-flex justify-content-between align-items-center p-5 position-absolute w-100" style="top: 0;">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none" style="gap: 10px;">
        <span class="d-flex justify-content-center align-items-center"
              style="border: 2px solid; border-radius: 50%; padding: 5px; width: 24px; height: 24px;">
            <i class="ti ti-chevron-left"></i>
        </span>
        <span class="ms-2">Back</span>
    </a>

    <div class="language-letters" style="cursor: pointer;">
        <h6> UKR | <strong>ENG</strong> | RUS</h6>
    </div>
</header>
<div class="info-container">
    <div class="row mb-5">
        <div class="col-md-12 word-container">
            <p><strong>Regain</strong>&#8482 is the first Artificial Intelligence (AI) mental health and skills platform
                designed to assess and assist in the rehabilitation and reintegration of victims of war back into a
                changing society. The platform provides an end-to-end central resource, process and all-encompassing
                solution for the mental well-being of returning soldiers and citizens alike. We recognise that no two
                people are identical - all have their own individual experiences or traumas and the use of AI allows for
                a tailored diagnosis for each and every individual. Our personalised assessment process creates
                patient-specific treatment, rehabilitation and reintegration pathways.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-6 px-2">
            <button type="button" class="btn btn-custom-prev btn-block">Previous</button>
        </div>
        <div class="col-6 px-2">
            <button type="button" class="btn btn-custom-next btn-block">Next</button>
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

    const popup = document.getElementById('popup');
    const forgotPasswordLink = document.getElementById('forgot-password-link');
    const closePopup = document.getElementById('close-popup');

    forgotPasswordLink.addEventListener('click', (e) => {
        e.preventDefault();
        popup.style.display = 'flex';
    });

    closePopup.addEventListener('click', () => {
        popup.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    });
</script>
</body>
</html>
