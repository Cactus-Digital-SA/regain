<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regain Email</title>
    <style>
        /* General Styles */
        html {
            overflow-x: hidden;
        }

        body {
            background: #F1EDE9;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            color: #0A133A;
        }

        /* Email Container */
        .email-container {
            padding: 50px 70px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 2; /* Ensure content is on top */
            overflow: hidden;
        }

        /* Header Section */
        .email-header {
            text-align: center;
            z-index: 3;
            position: relative;
        }

        .email-header img {
            width: 100%;
            height: auto;
            margin-bottom: 30px;
            scale: 150%;
        }

        /* Body Section */
        .email-body {
            text-align: center;
            margin-top: 20px;
            z-index: 3;
            position: relative;
        }

        .email-body-text{
            gap: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
            margin: 0 auto;
        }

        .email-body-text h1 {
            font-family: Playfair Display, serif;
            font-size: 50px;
            font-weight: 700;
            line-height: 50px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        .email-body-text p{
            font-size: 20px;
            font-weight: 400;
            line-height: 28px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
        }

        .custom-btn {
            width: 386px;
            height: 50px;
            border-radius: 30px;
            background-color: #0A133A;
            border: none;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            line-height: 50px;
            text-decoration: none;
            display: inline-block;
            margin-top: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .custom-btn:hover {
            background-color: #3e4273;
        }

        /* Login Details Section */
        .login-details {
            margin: 70px 0 50px 0;
            text-align: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            z-index: 3;
            position: relative;
            gap: 15px;
        }

        /* Username and password container */
        .login-details .username,
        .login-details .password {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            gap: 20px;
            max-width: 500px;
        }

        /* Label styling */
        .login-details label {
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Input field styling */
        .login-details .field {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            padding: 12px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            width: 100%;
            max-width: 300px;
            box-sizing: border-box;
        }

        /* Contact Info Section */
        .contact-info {
            text-align: left;
            margin-top: 15px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            z-index: 3;
            position: relative;
        }

        .contact-info p {
            text-align: center;
            font-size: 17px;
            font-weight: 400;
            line-height: 28px;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            margin-bottom: 20px;
        }

        .contact-info .info-grid {
            padding: 20px;
            display: flex;
            width: 100%;
            justify-content: space-between;
            gap: 20px;
        }

        .info-block {
            text-align: left;
           display: flex;
            flex-direction: column;
        }

        .info-block strong {
            display: block;
            margin-bottom: 5px;
            font-size: 17px;
            font-weight: 700;
            line-height: 28px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;

        }

        .info-block div {
            margin-bottom: 5px;
            font-size: 18px;
            font-weight: 700;
            line-height: 28px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
        }

        .info-block div img {
        margin-bottom: 3px;
        }

        .info-block small {
            font-size: 14px;
            font-weight: 400;
            line-height: 16px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            color: #6c757d;
            margin-bottom: 10px;
        }

        /* Decorative Circles */
        .circle-bg {
            position: absolute;
            border-radius: 50%;
            opacity: 1;
            z-index: 1; /* Ensure circles are below content */
        }

        .circle1 {
            width: 370px;
            height: 370px;
            background-color: #EFEBBD;
            top: -10rem;
            left: -10rem;
        }

        .circle2 {
            width: 370px;
            height: 370px;
            background-color: #AEB2C7;
            bottom: -15rem;
            right: -10rem;
        }

        .circle3 {
            width: 230px;
            height: 230px;
            background-color: #789071;
            top: 10rem;
            right: -8rem;
        }

        .circle4 {
            width: 200px;
            height: 200px;
            background-color: #EFEBBD;
            bottom: -8rem;
            left: 15rem;
        }

        .circle5 {
            width: 270px;
            height: 270px;
            background-color: #999AC6;
            bottom: 20rem;
            left: -10rem;
        }

        .email-footer{
            margin: 5rem 0 2rem 0;
            z-index: 2;
        }

        .email-footer p{
            font-size: 12px;
            font-weight: 400;
            line-height: 15px;
            text-align: center;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            margin-bottom: 0;
            color: #0A133A;
        }

        @media (max-width: 1200px) {
            .email-header img{
                scale: 120%;
            }
        }


        @media (max-width: 800px) {
            .circle1 {
                background-color: #EFEBBD;
                top: -15rem;
                left: -15rem;
            }

            .circle2 {
                background-color: #AEB2C7;
                bottom: -20rem;
                right: -15rem;
            }

            .circle3 {
                background-color: #789071;
                top: 3rem;
                right: -10rem;
            }

            .circle4 {
                background-color: #EFEBBD;
                bottom: -10rem;
                left: 0;
            }

            .circle5 {
                background-color: #999AC6;
                bottom: 20rem;
                left: -15rem;
            }

            .contact-info p {
                width: 80%;
            }

            .email-header img {
                scale: 100%;
            }

            .email-container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .email-body-text h1{
                font-size: 35px;
            }

            .email-body-text p{
                font-size: 18px;
                line-height: 22px;
            }

            .contact-info {
                align-items: center;
                text-align: center;
            }

            .contact-info .info-grid {
                display: grid;
                width: 80%;
                grid-template-columns: repeat(2, auto);
                row-gap: 35px;
                column-gap: 65px;
                justify-content: center;
                align-items: center;
            }
        }

        @media (max-width: 550px) {
            .email-body{
                margin-top: 25px;
            }

            .custom-btn{
                width: 300px;
            }

            .email-container {
                padding: 2rem;
            }

            .username, .password {
                flex-direction: column;
                gap: 5px !important;
            }

            .contact-info .info-grid {
                width: 100%;
            }
            .contact-info .info-grid {
                width: auto;
                grid-template-columns: repeat(1, 1fr) !important;
            }
        }

        @media (max-width: 600px) {
            .email-container {
                padding: 2rem 0.5rem;
            }
        }
    </style>
<body>
<div class="email-container">
    <div class="circle-bg circle1"></div>
    <div class="circle-bg circle2"></div>
    <div class="circle-bg circle3"></div>
    <div class="circle-bg circle4"></div>
    <div class="circle-bg circle5"></div>
    <div class="email-header">
        <img src="{{Vite::asset('resources/images/logo/regain-logo-black.svg')}}" alt="Logo">
    </div>
    <div class="email-body">
        <div class="email-body-text">
            <h1 class="email-body-title">Hello</h1>
            <p>
                Following your registration with the <strong>Ministry of Regain</strong>, please click below to download
                the <strong>Regain App</strong> and start your journey using the login details below.
            </p>
        </div>
        <a href="#" class="custom-btn">Click Here</a>

        <div class="login-details">
            <div class="username">
                <label for="username">Username:</label>
                <div class="field" id="username">OlhaMaximova89</div>
            </div>
            <div class="password">
                <label for="password">Password:</label>
                <div class="field" id="password">35dsjk1</div>
            </div>
        </div>
    </div>

    <div class="contact-info">
        <p>If you ever need to talk, or just need some help, please contact one of our community partner
            organisations.</p>
        <div class="info-grid">
            <div class="info-block">
                <strong>Lifeline Ukraine:</strong>
                <small>Available 24/7</small>
                <div><img src="{{Vite::asset('resources/images/circle-icons/phone-filled.svg')}}" alt="">
                    7333</div>
            </div>
            <div class="info-block">
                <strong>Spirit:</strong>
                <small>Available 24/7</small>
                <div><img src="{{Vite::asset('resources/images/circle-icons/phone-filled.svg')}}" alt="">
                    0800 333 161</div>
            </div>
            <div class="info-block">
                <strong>Stavrophygion-058:</strong>
                <small>Available 12am-11pm</small>
                <div><img src="{{Vite::asset('resources/images/circle-icons/phone-filled.svg')}}" alt="">
                    058</div>
            </div>
            <div class="info-block">
                <strong>OCTS:</strong>
                <small style="margin-bottom: 5px">Mon-Fri: 10am-8am</small>
                <small>Sat-Sun: 7pm-8am</small>
                <div><img src="{{Vite::asset('resources/images/circle-icons/phone-filled.svg')}}" alt="">
                    0487 327715</div>
                <div><img src="{{Vite::asset('resources/images/circle-icons/phone-filled.svg')}}" alt="">
                    0482 226565</div>
            </div>
        </div>
    </div>

    <div class="email-footer">
        <p>&copy; 2024 Regain<sup>&trade;</sup> - Genecode DX Limited</p>
        <p>Created and Developed by Cactus Digital Growth</p>
    </div>
</div>

</body>

</html>
