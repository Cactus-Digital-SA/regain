<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regain Email</title>
</head>
<body
    style="background: #F1EDE9; font-family: Arial, sans-serif; margin: 0; padding: 0; color: #0A133A; text-align: center;">

<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td align="left" valign="top" width="50%">
            <div style="width: 150px; height: 150px; background-color: #EFEBBD;
                border-radius: 0 0 100% 0;"></div>
        </td>
        <td align="right" valign="top" width="50%">
            <div style="width: 150px; height: 150px; background-color: #AEB2C7;
                border-radius: 0 0 0 100%;"></div>
        </td>
    </tr>
</table>
<!-- Main Email Container -->
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td align="center">
            <div style="max-width: 600px; margin: auto; padding: 0 20px; text-align: center;">

                <!-- Logo -->
                <div style="margin-bottom: 50px;">
                    <img src="https://i.imgur.com/ui4PkNo.png"
                         alt="Regain Logo"
                         style="width: 200px; height: auto;">
                </div>


                <!-- Greeting -->
                <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 50px;">Hello</h1>
                <p style="font-size: 18px; font-weight: 400; line-height: 1.5; margin-bottom: 50px;">
                    Following your registration with the <strong>Ministry of Regain</strong>, please click below to
                    download
                    the <strong>Regain App</strong> and start your journey using the login details below.
                </p>

                <!-- Download Button -->
                <a href="https://platform.regain.world"
                   style="display: inline-block; width: 250px; padding: 15px; background-color: #0A133A; color: white; text-decoration: none; font-size: 16px; font-weight: 600; border-radius: 30px; text-align: center;">
                    Click Here
                </a>

                <!-- Login Details -->
                <div style="margin-top: 50px; width: 100%">
                    <div style="margin-bottom: 10px;">
                        <label style="font-size: 14px; font-weight: 600;">Username:</label>
                        <div
                            style="display: inline-block; background: #ffffff; border: 1px solid #d9d9d9; padding: 10px 15px; border-radius: 10px; font-size: 14px; font-weight: 500; text-align: center; width: 200px">
                            {{ $userName }}
                        </div>
                    </div>
                    <div style="margin-bottom: 20px; width: 100%">
                        <label style="font-size: 14px; font-weight: 600;">Password:</label>
                        <div
                            style="display: inline-block; background: #ffffff; border: 1px solid #d9d9d9; padding: 10px 15px; border-radius: 10px; font-size: 14px; font-weight: 500; text-align: center; width: 200px">
                            {{ $password }}
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>

<!-- Contact Information -->
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td align="center">
            <div style="max-width: 600px; margin-top: 0; padding: 20px; text-align: center;">
                <p style="font-size: 17px; font-weight: 400; line-height: 1.5; margin-bottom: 40px">
                    If you ever need to talk, or just need some help,<br> please contact one of our community partner
                    organisations.
                </p>

                <!-- Contact List -->
                <div style="display: block; margin-left: 100px;">
                    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <!-- First Contact -->
                            <td style="text-align: left; padding: 10px; width: 50%;">
                                <strong style="font-size: 17px; font-weight: 700;">Lifeline Ukraine:</strong><br>
                                <small style="font-size: 14px; color: #6c757d;">Available 24/7</small><br>
                                <span style="font-size: 18px; font-weight: 700;">7333</span>
                            </td>

                            <!-- Second Contact -->
                            <td style="text-align: left; padding: 10px; width: 50%;">
                                <strong style="font-size: 17px; font-weight: 700;">Stavropyghion-058:</strong><br>
                                <small style="font-size: 14px; color: #6c757d;">Available: 12am - 11pm</small><br>
                                <span style="font-size: 18px; font-weight: 700;">058</span>
                            </td>
                        </tr>

                        <tr>
                            <!-- Third Contact -->
                            <td style="text-align: left; padding: 10px; width: 50%;">
                                <strong style="font-size: 17px; font-weight: 700;">OCTS:</strong><br>
                                <small style="font-size: 14px; color: #6c757d;">Mon - Fri: 10am - 8am</small><br>
                                <span style="font-size: 18px; font-weight: 700;">0487 327715</span>
                            </td>

                            <!-- Fourth Contact -->
                            <td style="text-align: left; padding: 10px; width: 50%;">
                                <strong style="font-size: 17px; font-weight: 700;">Spirit:</strong><br>
                                <small style="font-size: 14px; color: #6c757d;">Available 24/7</small><br>
                                <span style="font-size: 18px; font-weight: 700;">0800 333 161</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                    <tr>
                        <td style="text-align: center; padding: 10px; width: 100%">
                            <small
                                style="display:block; font-size: 12px; font-weight: 400; color: #0A133A; margin: 40px 0 5px 0;">&copy;
                                2024 Regain<sup>&trade;</sup> - Genecode DX Limited</small>
                            <small style="display:block; font-size: 12px; font-weight: 400; color: #0A133A; margin: 0;">Created
                                and Developed by Cactus Digital Growth</small>
                        </td>
                    </tr>
                </table>

            </div>
        </td>
    </tr>
</table>

<!-- Footer & Bottom Circles -->
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td align="left" valign="bottom" width="50%">
            <div style="width: 150px; height: 150px; background-color: #789071;
                border-radius: 0 100% 0 0;"></div>
        </td>
        <td align="right" valign="bottom" width="50%">
            <div style="width: 150px; height: 150px; background-color: #999AC6;
                border-radius: 100% 0 0 0;"></div>
        </td>
    </tr>
</table>

</body>
</html>
