<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form</title>
<link rel="stylesheet" type="text/css" href="../../resources/css/login.css" />
</head>
<?php require_once '../components/headers/main_header.php';?>
<body>

<!-- Login Form Wrapper -->
<div class="outer-container login-wrapper">

    <!-- Main Container -->
    <div class="inner-container main-container">

        <!-- Content Container -->
        <div class="container content-container">

            <!-- Logo Image Container -->
            <div class="img-container logo-container">
                <img class="image logo-image" src="../../resources/images/logo.png" alt="profile icon.png" />
            </div>

            <!-- Form Section -->
            <div class="form-container login-form-container">
                <div class="form-inner-container form-elements-container">
                    
                    <!-- Error Message Display -->
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <?php $login_err = $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                        <div style="color: red;" class="alert alert-danger error-message">
                            <?php echo $login_err; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Actual Form -->
                    <form action="../helpers/login_handler.php" method="post" class="login-form">
                        <div class="field-container email-field-container">
                            <input type="text" id="email" name="email" placeholder="Enter e-mail or phone number" class="field input-field email-input" />
                        </div>
                        <div class="field-container password-field-container">
                            <input type="password" id="password" name="password" placeholder="Password" class="field input-field password-input" />
                        </div>
                        <div class="field-container submit-field-container">
                            <input type="submit" name="submit" value="Log in" class="submit-button" />
                        </div>
                    </form>

                    <!-- Sign-up Link -->
                    <div class="signup-container">
                        <p>Don't have an account?</p>
                        <div class="signup-link-container">
                            <a href="reg.php" class="signup-link">Sign-up</a> and create an account
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
