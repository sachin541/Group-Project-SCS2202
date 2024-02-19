<?php
require_once '../classes/database.php'; 
require_once '../classes/UserManager.php'; 
require_once '../components/headers/main_header.php';
require_once '../components/confirm_modal.php'; 

$database = new Database();
$db = $database->getConnection(); 

$userManager = new UserManager();

// Handle role filter
$roleFilter = isset($_GET['role_filter']) ? $_GET['role_filter'] : null;
$employees = $userManager->getAllEmployees($roleFilter);


$employeeId = isset($_GET['id']) ? $_GET['id'] : 16;
$employee = $userManager->getStaffById($employeeId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Center</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_manager/staff_center.css">
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_manager/staffProfile.css">
</head>
<body>
    <h1>Staff Center</h1>

    <!-- Role Filter Form -->
    <form action="" method="get" class="filter-form">
    <select name="role_filter">
        <option value="">All Roles</option>
        <?php
        $roles = $userManager->getDistinctRoles();
        foreach ($roles as $role) {
            echo '<option value="' . htmlspecialchars($role) . '"' . ($role === $roleFilter ? ' selected' : '') . '>' . htmlspecialchars($role) . '</option>';
        }
        ?>
    </select>
    <input type="submit" value="Filter">
    </form>

    <div class="table-container">
    <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Mobile No</th>
                    <th>Alternative Mobile No</th>
                    <th>Date of Birth</th>
                    <th>Salary</th>
                    <th>Staff ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <?php foreach ($employees as $row): ?>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['emp_role']) ?></td>
                        <td><?= htmlspecialchars($row['staff_name']) ?></td>
                        <td><?= htmlspecialchars($row['staff_address']) ?></td>
                        <td><?= htmlspecialchars($row['mobile_no']) ?></td>
                        <td><?= htmlspecialchars($row['alternative_mobile_no']) ?></td>
                        <td><?= htmlspecialchars($row['date_of_birth']) ?></td>
                        <td><?= htmlspecialchars($row['sal']) ?></td>
                        <td><?= htmlspecialchars($row['staff_id']) ?></td>
                        
                        <td>
                        <div class="action-buttons">
                            <!-- <form action="../helpers/employee_handler.php" method="post">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                
                                <input type="submit" class="edit-button" value="Edit">
                            </form> -->
                            <a href="?id=<?= $row['staff_id'] ?>&show_modal=1" class="details-btn">Details</a>


                            <a href="edit_staff.php?id=<?= $row['staff_id'] ?>" class="button-like-link">Edit</a>
                            <form action="../helpers/employee_handler.php" method="post">
                                <input type="hidden" name="id" value="<?= $row['staff_id'] ?>">
                                <input type="hidden" name="handler_type" value="remove_staff">
                                
                                <input type="submit" id="delete" class="delete-btn" value="Delete" data-message="Are you sure you want to delete this employee?">
                            </form>
                        </div>
                    </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>


    <div class="add-employee-container">
    <form action="./add_staff.php" method="post">
        <input type="submit" class="add-employee-button" value="Add New Employee">
    </form>
</div>

<div id="employeeProfileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalName"></h2>
        <!-- The rest of the employee details will go here -->
        <p id="modalRole"></p>
        <p id="modalAddress"></p>
        <p id="modalMobile"></p>
        <!-- Add more fields as necessary -->
        <img id="modalImage" src="" alt="Profile Picture" style="max-width: 100px; height: auto; display: none;">
    </div>
</div>

</body>

<script>
window.addEventListener('load', () => {
    // Code to display the modal if needed
    <?php if (isset($_GET['show_modal']) && $_GET['show_modal'] == 1 && isset($employee)) : ?>
        document.getElementById('modalName').textContent = '<?= htmlspecialchars($employee['staff_name']) ?>';
        document.getElementById('modalRole').textContent = '<?= htmlspecialchars($employee['emp_role']) ?>';
        document.getElementById('modalAddress').textContent = '<?= htmlspecialchars($employee['staff_address']) ?>';
        document.getElementById('modalMobile').textContent = '<?= htmlspecialchars($employee['mobile_no']) ?>';
        // Add more fields as necessary
        document.getElementById('employeeProfileModal').style.display = 'block';
    <?php endif; ?>

    // Close modal script
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('employeeProfileModal').style.display = 'none';
    });
});
</script>

</html>




