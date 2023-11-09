<?php
// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}
include_once '../utils/dbConnect.php';
$conn = OpenCon();
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = test_input($_POST["email"]);
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {

        // Prepare an insert statement
        $sql = "SELECT id, email, password, role FROM login_details WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $role);

                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["role"] = $role;

                            // Redirect user to home page
                            header("location: home.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else {
                    // Email doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    CloseCon($conn);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMarket - Login</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/login.css" />
</head>
<style>
    /* Style for error messages */
.invalid-feedback {
    color: red; /* Makes the text red */
    font-size: 0.85em; /* Adjust the size as needed */
    margin-top: 5px; /* Adds some space above the error message */
}

/* Style for invalid input fields */
.is-invalid {
    border: 1px solid red; /* Adds a red border to the input field */
}

/* Ensure that the class is-invalid is applied to input fields with errors */
.field.is-invalid {
    background-color: #ffcccc; /* Adds a light red background */
}

</style>
<body>

    <div class="outer-container">
        <div class="inner-container">
            <div class="container">
                <div class="img-container"><img class="image" src="../../resources/images/logo.png" alt="profile icon.png" /></div>
                <div class="form-container">
                    <div class="form-inner-container">
                        <div id="forget-pass"><a href="forgot_password.php">Forgot Password?</a></div>
                        <div class="center-content">
                            <?php
                            if (!empty($login_err)) {
                                echo '<div class="alert alert-danger">' . $login_err . '</div>';
                            }
                            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" , method="post">
                                <div class="field-container"><input type="text" id="email" name="email" placeholder="Enter e-mail or phone number" class="field" <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" /></div>
                                <span class="invalid-feedback error"><?php echo $email_err; ?></span>

                                <div class="field-container"><input type="password" id="password" name="password" placeholder="password" class="field" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" /></div>
                                <span class="invalid-feedback error"><?php echo $password_err; ?></span>

                                <div class="field-container"><input type="submit" onsubmit="" name="submit" value="Log in" /></div>
                            </form>
                            <p>Don't have an account?</p>
                            <div><a href="create_account.php">Sign-up</a> and create an account</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>