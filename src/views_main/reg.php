<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/login.css" />
</head>
<body>
    <?php require_once '../components/headers/main_header.php';?>

    <?php
    if (isset($_SESSION['registration_error'])) {
        $email_already_in_use_err = htmlspecialchars($_SESSION['registration_error']);
        unset($_SESSION['registration_error']);
    }
    ?>

    <!-- Registration Form -->
    <div class="flexbox">
        <div class="outer-container">
            <form action="../helpers/register_handler.php" method="post" class="form-container">
                <h1 class="title">Sign-Up</h1>
                
                <div class="form-group">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter e-mail" class="field" />
                </div>

                <div class="form-group">
                    <label for="password1" class="form-label">Your Password</label>
                    <input type="password" id="password1" name="password" placeholder="Password" class="field" />
                </div>

                <div class="form-group">
                    <label for="password2" class="form-label">Confirm Password</label>
                    <input type="password" id="password2" name="password_confirmation" placeholder="Confirm Password" class="field" />
                </div>

                <?php
                if (!empty($email_already_in_use_err)) {
                    echo '<div style="color: red;" class="alert alert-danger">' . $email_already_in_use_err . '</div>';
                }
                ?>

                <input type="submit" name="submit" value="Sign up" />

                <p>Already have an account? <a href="login.php">Login</a> to the existing account</p>
            </form>
            <img class="image" src="../../resources/images/complogo.png" alt="profile icon.png" />
        </div>
    </div>
</body>
</html>


