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
<!-- password is wrong  -->
<?php

if (isset($_SESSION['error_message'])) {
    
    $login_err = $_SESSION['error_message'];

    unset($_SESSION['error_message']); 
}
?>

<!-- Login Form -->
<div class="outer-container">
        <div class="inner-container">
            <div class="container">
                <div class="img-container"><img class="image" src="../../resources/images/logo.png" alt="profile icon.png" /></div>
                <div class="form-container">
                    <div class="form-inner-container">
                        
                        <div class="center-content">
                            <?php
                            if (!empty($login_err)) {
                                echo '<div style="color: red; class="alert alert-danger">' . $login_err . '</div>';
                            }
                            ?>
                            <form action="../helpers/login_handler.php" , method="post">
                                <div class="field-container">
                                    <input type="text" id="email" name="email" placeholder="Enter e-mail or phone number" class="field" /></div>
                               

                                <div class="field-container">
                                    <input type="password" id="password" name="password" placeholder="password" class="field" /></div>
                                

                                <div class="field-container"><input type="submit" onsubmit="" name="submit" value="Log in" /></div>
                            </form>
                            <p>Don't have an account?</p>
                            <div><a href="reg.php">Sign-up</a> and create an account</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>