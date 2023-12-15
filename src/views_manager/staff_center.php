<?php
require_once '../classes/database.php'; 
require_once '../classes/UserManager.php'; 
require_once '../components/headers/main_header.php';
$database = new Database();
$db = $database->getConnection(); 

$userManager = new UserManager();

// Handle role filter
$roleFilter = isset($_GET['role_filter']) ? $_GET['role_filter'] : null;
$employees = $userManager->getAllEmployees($roleFilter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Center</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/staff_center.css">
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
                            <a href="edit_staff.php?id=<?= $row['staff_id'] ?>" class="button-like-link">Edit</a>
                            <form action="../helpers/employee_handler.php" method="post">
                                <input type="hidden" name="id" value="<?= $row['staff_id'] ?>">
                                <input type="hidden" name="handler_type" value="remove_staff">
                                <input type="submit" class="delete-button" value="Delete" onclick="return confirm('Are you sure you want to delete this?');">
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
</body>
</html>

