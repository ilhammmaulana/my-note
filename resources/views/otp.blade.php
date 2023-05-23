<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note App - Password Reset OTP</title>
    <style>
        * {
            font-family: Helvetica, Arial, sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo a {
            font-size: 1.4em;
            color: #00466a;
            text-decoration: none;
            font-weight: 600;
        }

        .otp-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .otp {
            background-color: #00466a;
            margin: 0 auto;
            width: fit-content;
            padding: 10px;
            color: #fff;
            border-radius: 4px;
            font-size: 1.5em;
        }

        .message {
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .disclaimer {
            font-size: 0.9em;
        }

        .disclaimer p {
            margin-bottom: 5px;
        }

        hr {
            border: none;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <a href="#">Note App</a>
        </div>
        <p class="message">Hi,</p>
        <p>You are receiving this email because you have requested to reset your password for your Note App account. To proceed with the password reset, please use the following OTP (One-Time Password) within the next 5 minutes:</p>
        <div class="otp-container">
            <div class="otp">{{ $otp }}</div>
        </div>
        <div class="disclaimer">
            <p>If you did not initiate this password reset, please disregard this email.</p>
            <p>Thank you for using Note App.</p>
        </div>
        <hr>
    </div>
</body>
</html>
