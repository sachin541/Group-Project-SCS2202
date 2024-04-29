<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee</title>

    <link rel="stylesheet" type="text/css" href="../../resources/css/css_manager/add_emp.css" />
</head>

<body>
    <?php require_once '../components/headers/main_header.php';

    if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'manager')) {
        header('Location: ../views_main/denied.php');
        exit;
    }

    ?>
    <?php if (isset($_SESSION['error'])):
        $validationError = htmlspecialchars($_SESSION['error']);
        unset($_SESSION['error']); // Clear the message after displaying
    
        ?>
    <?php endif; ?>



    <!--<form action="../helpers/add_employee.php" method="post" enctype="multipart/form-data">
        <p class="form-heading">Add New Employee</p>
        <h3 class="section-heading">Registration Information</h3>
        <div>
            <input type="email" name="email" placeholder="Email" required>
            
        </div>
        <div>
            <input type="password" name="user_password" placeholder="Password" required>
        </div>
        <div>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="staff">Staff</option>
                <option value="deliverer">Deliverer</option>
                <option value="technician">Technician</option>
            </select>
        </div>

        <h3 class="section-heading">Personal Details</h3>
        <div>
            <input type="text" name="staff_name" placeholder="Name" required>
        </div>
        <div>
            <input type="text" name="staff_address" placeholder="Address" required>
        </div>
        <div>
            <input type="text" name="mobile_no" placeholder="Mobile Number" required>
        </div>
        
        <div>
            <input type="date" name="date_of_birth" placeholder="Date of Birth" required>
        </div>
        <div>
            <input type="number" name="sal" placeholder="Salary" required>
        </div>
        <div>
            <input type="text" name="nic" placeholder="NIC" required>
        </div>

        <h3 class="section-heading">Profile Picture</h3>
        
        <div>
            <input type="file" name="profile_picture"  >
        </div>

        <?php if (!empty($validationError)): ?>
                <div style="color: red;" class="alert alert-danger"><?= $validationError ?></div>
            <?php endif; ?>

            <input type="hidden" name="form_mode" value="add">          
        <div>
            <input type="submit" value="Add Employee">
        </div>
    </form>-->

    <form action="../helpers/add_employee.php" method="post" enctype="multipart/form-data">
        <h1 class="form-heading">Add New Employee</h1>
        <div class="form-all-section">
            <div class="form-section">
                <h3 class="section-heading">Registration Information</h3>
                <div>
                    <p class="form_section-p">Email</p>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div>
                    <p class="form_section-p">Password</p>
                    <input type="password" name="user_password" placeholder="Password" required>
                </div>
                <div>
                    <p class="form_section-p">Re-Enter Password</p>
                    <input type="password" name="user_re_password" placeholder="Re-Enter Password" required>
                </div>
                <div>
                    <p class="form_section-p">Role</p>
                    <select name="role" required>
                        <option value="">Select Role</option>
                        <option value="staff">Staff</option>
                        <option value="deliverer">Deliverer</option>
                        <option value="technician">Technician</option>
                        <!-- Add other roles as necessary -->
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-heading">Personal Details</h3>
                <div>
                    <p class="form_section-p">Name</p>
                    <input type="text" name="staff_name" placeholder="Name" required>
                </div>
                <div>
                    <p class="form_section-p">Address</p>
                    <input type="text" name="staff_address" placeholder="Address" required>
                </div>
                <div>
                    <p class="form_section-p">Mobile No:</p>
                    <input type="text" name="mobile_no" placeholder="Mobile Number" required>
                </div>
                <div>
                    <p class="form_section-p">DOB</p>
                    <input type="date" name="date_of_birth" placeholder="Date of Birth" required>
                </div>
                <div>
                    <p class="form_section-p">Salary</p>
                    <input type="number" name="sal" placeholder="Salary" required>
                </div>
                <div>
                    <p class="form_section-p">NIC</p>
                    <input type="text" name="nic" placeholder="NIC" required>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-heading">Profile Picture</h3>
                <div>
                    <input type="file" name="profile_picture">
                </div>
            </div>
        </div>

        <?php if (!empty($validationError)): ?>
            <div style="color: red;" class="alert alert-danger"><?= $validationError ?></div>
        <?php endif; ?>

        <input type="hidden" name="form_mode" value="add">
        <div>
            <input type="submit" value="Add Employee">
        </div>
    </form>

</body>

</html>
