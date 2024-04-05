<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee Details</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_manager/add_emp.css" />
</head>
<body>
    <?php 
    require_once '../components/headers/main_header.php'; 
    require_once '../classes/database.php'; 
    require_once '../classes/UserManager.php'; 

    $database = new Database();
    $db = $database->getConnection();
    $userManager = new UserManager();

    $staff_id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($staff_id) {
        // Fetch staff details for editing
        $staffDetails = $userManager->getStaffById($staff_id);
    } else {
        // Handle case where no ID is provided, or redirect
        echo "No staff ID provided.";
        exit; // Stop script execution if no ID
    }

    if (isset($_SESSION['error'])) {
        $validationError = htmlspecialchars($_SESSION['error']);
        unset($_SESSION['error']); // Clear the message after displaying
    }
    ?>

    <form action="../helpers/employee_handler.php" method="post" enctype="multipart/form-data">
        <h2 class="form-heading">Edit Employee Details</h2>
        <input type="hidden" name="form_mode" value="edit">
        <input type="hidden" name="staff_id" value="<?= htmlspecialchars($staff_id) ?>">

        <h3 class="section-heading">Registration Information</h3>
        <div>
            <p>Email: <?= htmlspecialchars($staffDetails['email']) ?></p>
        </div>

        <div>
            <select name="emp_role" required>
                <option value="">Select Role</option>
                <!-- Dynamically select the role if in edit mode -->
                <option value="staff" <?=  $staffDetails['emp_role'] == "staff" ? 'selected' : '' ?>>Staff</option>
                <option value="deliverer" <?= $staffDetails['emp_role'] == "deliverer" ? 'selected' : '' ?>>Deliverer</option>
                <option value="technician" <?= $staffDetails['emp_role'] == "technician" ? 'selected' : '' ?>>Technician</option>
            </select>
        </div>

        <h3 class="section-heading">Personal Details</h3>
        <div>
            <input type="text" name="staff_name" placeholder="Name" required value="<?= htmlspecialchars($staffDetails['staff_name']) ?>">
        </div>
        <div>
            <input type="text" name="staff_address" placeholder="Address" required value="<?= htmlspecialchars($staffDetails['staff_address']) ?>">
        </div>
        <div>
            <input type="text" name="mobile_no" placeholder="Mobile Number" required value="<?= htmlspecialchars($staffDetails['mobile_no']) ?>">
        </div>
        <div>
            <input type="date" name="date_of_birth" required value="<?= htmlspecialchars($staffDetails['date_of_birth']) ?>">
        </div>
        <div>
            <input type="number" name="sal" placeholder="Salary" required value="<?= htmlspecialchars($staffDetails['sal']) ?>">
        </div>
        <div>
            <input type="text" name="nic" placeholder="NIC" required value="<?= htmlspecialchars($staffDetails['nic']) ?>">
        </div>

        <h3 class="section-heading">Profile Picture</h3>
        <div>
            <input type="file" name="profile_picture">
        </div>

        <?php if (!empty($validationError)): ?>
            <div style="color: red;" class="alert alert-danger"><?= $validationError ?></div>
        <?php endif; ?>

        <input type="hidden" name="handler_type" value="update_staff">
        <div>
            <input type="submit" value="Update Employee">
        </div>
    </form>
</body>
</html>





