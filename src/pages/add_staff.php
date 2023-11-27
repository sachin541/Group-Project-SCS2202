<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form</title>
<link rel="stylesheet" type="text/css" href="../../resources/css/login.css" />
<link rel="stylesheet" type="text/css" href="../../resources/css/add_emp.css" />
</head>
<body>
<?php
            session_start();
            if (isset($_SESSION['add_staff_error'])) {
                $email_already_in_use_err = htmlspecialchars($_SESSION['add_staff_error']);
                unset($_SESSION['add_staff_error']); // Clear the message after displaying
            }
?>

<form action="../helpers/add_employee.php" method="post">
    <div>
        <input type="email" name="email" placeholder="Email" required>
        
    </div>
    <?php
            if (!empty($email_already_in_use_err)) {
                echo '<div style="color: red; class="alert alert-danger">' . $email_already_in_use_err . '</div>';
                }
        ?>
    <div>
        <input type="password" name="user_password" placeholder="Password" required>
    </div>
    <div>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="staff">Staff</option>
            <option value="deliverer">Deliverer</option>
            <option value="technician">Technician</option>
            <!-- Add other roles as necessary -->
        </select>
    </div>
    <div>
        <input type="text" name="staff_name" placeholder="Name" required>
    </div>
    <div>
        <input type="text" name="staff_address" placeholder="Address" required>
    </div>
    <div>
        <input type="text" name="mobile_no" placeholder="Mobile Number">
    </div>
    <div>
        <input type="text" name="alternative_mobile_no" placeholder="Alternative Mobile Number">
    </div>
    <div>
        <input type="date" name="date_of_birth" placeholder="Date of Birth">
    </div>
    <div>
        <input type="number" name="sal" placeholder="Salary">
    </div>
    
    <div>
        <input type="submit" value="Add Employee">
    </div>
</form>

   
</body>
</html>