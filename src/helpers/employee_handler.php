<?php
session_start(); // Ensure session start at the beginning of the script
require_once '../classes/database.php'; 
require_once '../classes/UserManager.php'; 

$database = new Database();
$db = $database->getConnection(); 
$userManager = new UserManager($db); // Pass the database connection to UserManager

$redirectPath = '../views_manager/'; // Base redirection path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $handler_type = $_POST['handler_type'] ?? '';

    if ($handler_type == "update_staff") {
        $staff_id = $_POST['staff_id'];
        $name = $_POST['staff_name']; 
        $address = $_POST['staff_address'];
        $mobile_no = $_POST['mobile_no'];
        $alternative_mobile_no = $_POST['alternative_mobile_no'] ?? '';
        $date_of_birth = $_POST['date_of_birth'];
        $sal = $_POST['sal'];
        $role = $_POST['emp_role']; 
        $nic = $_POST['nic'];

        // Validate input data
        if (preg_match('/[0-9]/', $name)) {
            $_SESSION['error'] = 'Name cannot contain numbers.';
            header('Location: ' . $redirectPath . 'edit_staff.php?id=' . $staff_id);
            exit;
        }

        if (!preg_match('/^07\d{8}$/', $mobile_no)) {
            $_SESSION['error'] = 'Invalid mobile number format.';
            header('Location: ' . $redirectPath . 'edit_staff.php?id=' . $staff_id);
            exit;
        }

        if (!preg_match('/^\d{9}[vxVX]$|^\d{12}$/', $nic)) {
            $_SESSION['error'] = 'Invalid NIC format.';
            header('Location: ' . $redirectPath . 'edit_staff.php?id=' . $staff_id);
            exit;
        }

        $profile_picture = null;
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);
        }

        // Attempt to update the employee
        $updateSuccess = $userManager->updateEmployee($staff_id, $name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $role, $nic, $profile_picture);
        
        if ($updateSuccess) {
            $_SESSION['message'] = 'Employee updated successfully.';
            header('Location: ' . $redirectPath . 'staff_center.php');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update employee.';
            header('Location: ' . $redirectPath . 'edit_staff.php?id=' . $staff_id);
            exit;
        }
    } elseif ($handler_type == "remove_staff") {
        $id = $_POST['staff_id'];
        if ($userManager->deleteEmployee($id)) {
            $_SESSION['message'] = 'Employee deleted successfully.';
            header('Location: ' . $redirectPath . 'staff_center.php');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to delete employee.';
            header('Location: ' . $redirectPath . 'staff_center.php');
            exit;
        }
    }
}

