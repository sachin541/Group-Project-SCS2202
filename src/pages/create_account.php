 <?php
    include_once '../utils/dbConnect.php';

    $conn = OpenCon();
    // Define variables and initialize with empty values
    $email = $password = $confirm_password = $name = $address = $mobile1 = $mobile2 = $dob = "";
    $email_err = $password_err = $confirm_password_err = $name_err = $address_err = $mobile1_err = $dob_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = test_input($_POST["email"]);
        // Validate email
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter an email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        } else {
            // Prepare a select statement
            $sql = "SELECT id FROM login_details WHERE email = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_email);

                // Set parameters
                $param_email = trim($_POST["email"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $email_err = "This email is already taken.";
                    } else {
                        $email = trim($_POST["email"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Validate password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter a password.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password must have at least 6 characters.";
        } else {
            $password = trim($_POST["password"]);
        }

        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Password did not match.";
            }
        }

        // Validate name
        if (empty(trim($_POST["name"]))) {
            $name_err = "Please enter your name.";
        }
        // Validate address
        if (empty(trim($_POST["address"]))) {
            $address_err = "Please enter your address.";
        }
        // Validate mobile1
        if (empty(trim($_POST["mobile1"]))) {
            $mobile1_err = "Please enter your mobile.";
        }

        // Validate dob
        if (empty(trim($_POST["dob"]))) {
            $dob_err = "Please enter your date of birth.";
        }

        // Check input errors before inserting in database
        if (empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($name) && empty($address_err) && empty($mobile1_err) && empty($dob_err)) {

            // Prepare an insert statement
            $sql = "INSERT INTO login_details (email, password, role) VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_password, $role);


                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $role = "customer";


                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // echo "Records added successfully.";
                    // Redirect to login page
                    //header("location: login.php");
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }

            $get_customer_id = "SELECT id FROM login_details ORDER BY id DESC LIMIT 1";
            $cust_id = "";
            if ($result = mysqli_query($conn, $get_customer_id)) {

                $row = mysqli_fetch_array($result);

                $cust_id = $row['id'];
            }

            $insert_customer_details = "INSERT INTO customer_details(name, address, mobile_no, alternative_mobile_no, date_of_birth, rank, loyalty_points, customer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $insert_customer_details)) {
                mysqli_stmt_bind_param($stmt, "ssssssss", $param_name, $param_address, $param_mobile, $param_al_mobile_no, $param_dob, $param_rank, $param_loyalty, $param_id);

                $param_name = $_POST["name"];
                $param_address = $_POST["address"];
                $param_mobile = $_POST["mobile1"];
                $param_al_mobile_no = $_POST["mobile2"];
                $param_dob = $_POST["dob"];
                $param_rank = 0;
                $param_loyalty = 0;
                $param_id = $cust_id;
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    echo "New customer created successfully!";
                    header("location: login.php");
                    exit();
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
     <title>Register</title>
     <link rel="stylesheet" type="text/css" href="../../resources/css/login.css" />
 </head>
 <style>

    /* General form styling */
form {
  background: #f7f7f7;
  padding: 20px;
  max-width: 500px;
  margin: 20px auto;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
}

/* Container for each form field */
.field-container {
  margin-bottom: 15px;
}

/* Style labels */
label {
  display: block;
  margin-bottom: 5px;
}

/* Style input fields */
input.field {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box; /* To make sure padding doesn't increase the width */
  margin-bottom: 10px;
}

/* Style input fields when they are active/have focus */
input.field:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

/* Style the invalid input fields */
input.is-invalid {
  border-color: #dc3545;
}

/* Style the error message */
span.invalid-feedback.error {
  color: #dc3545;
  font-size: 0.9em;
  display: block;
}

/* Style the submit button */
input[type="submit"] {
  padding: 10px 20px;
  background-color: #008000;
  border: none;
  border-radius: 4px;
  color: white;
  cursor: pointer;
  transition: background-color 0.2s;
}

/* Change background color of submit button on hover */
input[type="submit"]:hover {
  background-color: #0056b3;
}

/* Style for existing account prompt and link */
p, div {
  text-align: center;
}

/* Style the login link */
a {
  color: #007bff;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}








    </style>
 <body>

     <div class="outer-container">
         <div class="inner-container">
             <div class="container">
                 <div class="img-container"><img class="image" src="../../resources/images/logo.png" alt="profile icon.png" /></div>
                 <div class="form-container">
                     <div class="form-inner-container">
                         <div class="center-content">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                        <div class="field-container">
                                            <label for="name">Name:</label>
                                            <input type="text" id="name" name="name" placeholder="Enter name" class="field" <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?> value="<?php echo $name; ?>" />
                                            <span class="invalid-feedback error"><?php echo $name_err; ?></span>
                                        </div>

                                        <div class="field-container">
                                            <label for="email">E-mail or Phone:</label>
                                            <input type="text" id="email" name="email" placeholder="Enter e-mail or phone number" class="field" <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?> value="<?php echo $email; ?>" />
                                            <span class="invalid-feedback error"><?php echo $email_err; ?></span>
                                        </div>

                                        <div class="field-container">
                                            <label for="password1">Password:</label>
                                            <input type="password" id="password1" name="password" placeholder="Password" class="field" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> value="<?php echo $password; ?>" />
                                            <span class="invalid-feedback error"><?php echo $password_err; ?></span>
                                        </div>

                                        <div class="field-container">
                                            <label for="password2">Confirm Password:</label>
                                            <input type="password" id="password2" name="confirm_password" placeholder="Re-password" class="field" <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?> value="<?php echo $confirm_password; ?>" />
                                            <span class="invalid-feedback error"><?php echo $confirm_password_err; ?></span>
                                        </div>

                                        <div class="field-container">
                                            <label for="address">Address:</label>
                                            <input type="text" id="address" name="address" placeholder="Enter address" class="field" <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?> value="<?php echo $address; ?>" />
                                            <span class="invalid-feedback error"><?php echo $address_err; ?></span>
                                        </div>

                                        <div class="field-container">
                                            <label for="mobile1">Mobile:</label>
                                            <input type="number" id="mobile1" name="mobile1" placeholder="Enter Mobile" class="field" <?php echo (!empty($mobile1_err)) ? 'is-invalid' : ''; ?> value="<?php echo $mobile1; ?>" />
                                            <span class="invalid-feedback error"><?php echo $mobile1_err; ?></span>
                                        </div>

                                        <div class="field-container">
                                            <label for="mobile2">Alternative Mobile:</label>
                                            <input type="number" id="mobile2" name="mobile2" placeholder="Enter Alternative Mobile" class="field" value="<?php echo $mobile2; ?>" />
                                        </div>

                                        <div class="field-container">
                                            <label for="dob">Date of Birth:</label>
                                            <input type="date" id="dob" name="dob" placeholder="Enter Date of Birth" class="field" <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?> value="<?php echo $dob; ?>" />
                                            <span class="invalid-feedback error"><?php echo $dob_err; ?></span>
                                        </div>

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