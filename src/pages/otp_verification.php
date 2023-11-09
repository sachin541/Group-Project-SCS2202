<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP verification</title>
    <link rel="stylesheet" href="../../resources/css/login.css">
    <style>
        .otp-field {
            height: 40px;
            width: 200px;
        }

        input[type="text"] {
            text-align: center;
            letter-spacing: 1rem;
            font-size: larger;
        }
    </style>
</head>

<body>
    <div class="outer-container">
        <div class="inner-container">
            <div class="container">
                <div class="img-container"><img class="image" src="../../resources/images/logo.png" alt="profile icon.png" /></div>
                <div class="form-container">
                    <div class="form-inner-container">
                        <div class="center-content">
                            <form action="">
                                <div class="field-container" style="text-align: center;"><input type="text" maxlength="4" id="email" placeholder="O T P" class="otp-field" /></div>
                                <div class="field-container" style="text-align: center;"><input type="submit" /></div>
                            </form>
                            <p>Resend OTP in {_ _ s}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>