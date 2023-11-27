<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login and Registration Form</title>
<link rel="stylesheet" type="text/css" href="../../resources/css/login.css" />
</head>
            <?php
            session_start();
            if (isset($_SESSION['registration_error'])) {
                $email_already_in_use_err = htmlspecialchars($_SESSION['registration_error']);
                unset($_SESSION['registration_error']); // Clear the message after displaying
            }
            ?>
<body>

<div class="outer-container">
    <div class="inner-container">
        <div class="container">
            <div class="img-container"><img class="image" src="../../resources/images/logo.png" alt="profile icon.png" /></div>
            <div class="form-container">
                <div class="form-inner-container">
                    <div class="center-content">
                       <form action="../helpers/register_handler.php" method="post">

                                   <!-- <div class="field-container">
                                       <label for="name">Name:</label>
                                       <input type="text" id="name" name="name" placeholder="Enter name" class="field"  />
                                       <span class="invalid-feedback error"></span>
                                   </div> -->

                                   <div class="field-container">
                                       <label for="email">E-mail</label>
                                       <input type="text" id="email" name="email" placeholder="Enter e-mail" class="field"  />
                                       <?php
                                        if (!empty($email_already_in_use_err)) {
                                        echo '<div style="color: red; class="alert alert-danger">' . $email_already_in_use_err . '</div>';
                                        }
                                        ?>
                                   </div>

                                   <div class="field-container">
                                       <label for="password1">Password:</label>
                                       <input type="password" id="password1" name="password" placeholder="Password" class="field"  />
                                       <span class="invalid-feedback error"></span>
                                   </div>

                                   <!-- <div class="field-container">
                                       <label for="password2">Confirm Password:</label>
                                       <input type="password" id="password2" name="confirm_password" placeholder="Re-password"  />
                                       <span class="invalid-feedback error"></span>
                                   </div>

                                   <div class="field-container">
                                       <label for="address">Address:</label>
                                       <input type="text" id="address" name="address" placeholder="Enter address" class="field"  />
                                       <span class="invalid-feedback error"><?php ?></span>
                                   </div>

                                   <div class="field-container">
                                       <label for="mobile1">Mobile:</label>
                                       <input type="number" id="mobile1" name="mobile1" placeholder="Enter Mobile" class="field" />
                                       <span class="invalid-feedback error"></span>
                                   </div>

                                   <div class="field-container">
                                       <label for="mobile2">Alternative Mobile:</label>
                                       <input type="number" id="mobile2" name="mobile2" placeholder="Enter Alternative Mobile" class="field" />
                                   </div>

                                   <div class="field-container">
                                       <label for="dob">Date of Birth:</label>
                                       <input type="date" id="dob" name="dob" placeholder="Enter Date of Birth" class="field"  />
                                       <span class="invalid-feedback error"></span>
                                   </div> -->

                                   <div class="field-container">
                                       <input type="submit" name="submit" value="Sign up" />
                                   </div>
                                   </form>
                        <p>Already have an account?</p>
                        <div><a href="login.php">Login</a> to the existing account</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
