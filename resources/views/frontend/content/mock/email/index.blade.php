<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regain Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Email Container */
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #F1EDE9;
            padding: 50px 70px;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 2; /* Ensure content is on top */
        }

        /* Header Section */
        .email-header {
            text-align: center;
            z-index: 3;
            position: relative;
        }

        .email-header img {
            width: 100%;
            max-width: 10em;
            height: auto;
            margin-bottom: 5px;
        }

        /* Body Section */
        .email-body {
            text-align: center;
            margin-top: 20px;
            z-index: 3;
            position: relative;
        }

        .email-body h1 {
            font-size: 25px;
            margin: 50px 0 25px 0;
            font-weight: bold;
        }

        .custom-btn {
            width: 200px;
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
            margin-top: 26px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .custom-btn:hover {
            background-color: #3e4273;
        }

        /* Login Details Section */
        .login-details {
            margin: 40px 0;
            text-align: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            z-index: 3;
            position: relative;
        }

        .login-details label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        .login-details .field {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            padding: 12px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 15px;
            width: 100%;
            max-width: 300px;
            text-align: center;
        }

        /* Contact Info Section */
        .contact-info {
            text-align: left;
            margin-top: 40px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            z-index: 3;
            position: relative;
        }

        .contact-info p {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .contact-info .info-grid {
            padding: 20px;
            display: grid;
            max-width: 450px;
            width: 100%;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-block {
            text-align: left;
        }

        .info-block strong {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .info-block div {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .info-block small {
            font-size: 12px;
            color: #6c757d;
        }

        /* Decorative Circles */
        .circle-bg {
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 1;
            z-index: 1; /* Ensure circles are below content */
        }

        .circle1 {
            background-color: #EFEBBD;
            top: -50px;
            left: -30px;
        }

        .circle2 {
            background-color: #AEB2C7;
            bottom: -50px;
            right: -30px;
        }

        .circle3 {
            background-color: #789071;
            top: 40px;
            right: -70px;
        }

        .circle4 {
            background-color: #EFEBBD;
            bottom: 100px;
            left: -40px;
        }

        .circle5 {
            background-color: #999AC6;
            top: 350px;
            left: -40px;
        }

        @media (max-width: 450px) {
            .email-container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .email-body p,
            .contact-info p {
                font-size: 14px;
            }

            .contact-info {
                align-items: center;
                text-align: center;
            }

            .contact-info .info-grid {
                width: auto;
                grid-template-columns: repeat(1, 1fr) !important;
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
        <h1>Hello</h1>
        <p>
            Following your registration with the <strong>Ministry of Regain</strong>, please click below to download
            the <strong>Regain App</strong> and start your journey using the login details below.
        </p>
        <a href="#" class="custom-btn">Click Here</a>

        <div class="login-details">
            <label for="username">Username:</label>
            <div class="field" id="username">OlhaMaximova89</div>
            <label for="password">Password:</label>
            <div class="field" id="password">35dsjk1</div>
        </div>
    </div>

    <div class="contact-info">
        <p>If you ever need to talk, or just need some help, please contact one of our community partner
            organisations.</p>
        <div class="info-grid">
            <div class="info-block">
                <strong>Lifeline Ukraine:</strong>
                <div>7333</div>
                <small>Available 24/7</small>
            </div>
            <div class="info-block">
                <strong>OCTS:</strong>
                <div>0487 327715 | 0482 226565</div>
                <small>Mon-Fri: 10am-8am | Sat-Sun: 7pm-8am</small>
            </div>
            <div class="info-block">
                <strong>Stavrophygion-058:</strong>
                <div>058</div>
                <small>Available 12am-11pm</small>
            </div>
            <div class="info-block">
                <strong>Spirit:</strong>
                <div>0800 333 161</div>
                <small>Available 24/7</small>
            </div>
        </div>
    </div>
</div>

</body>

</html>
