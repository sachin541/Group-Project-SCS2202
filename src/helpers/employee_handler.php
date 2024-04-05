<?php

require_once '../classes/database.php'; 
require_once '../classes/UserManager.php'; 
$database = new Database();
$db = $database->getConnection(); 
$userManager = new UserManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $handler_type = $_POST['handler_type'] ?? '';

    if ($handler_type == "remove_staff") {
        $id = $_POST['staff_id'];
        if ($userManager->deleteEmployee($id)) {
            header('Location: ../views_manager/staff_center.php');
            exit;
        }
    } elseif ($handler_type == "update_staff") {
        
        $staff_id = $_POST['staff_id'];
        $name = $_POST['staff_name']; // Adjusted to the correct field name
        $address = $_POST['staff_address'];
        $mobile_no = $_POST['mobile_no'];
        $alternative_mobile_no = $_POST['alternative_mobile_no'] ?? '';
        $date_of_birth = $_POST['date_of_birth'];
        $sal = $_POST['sal'];
        $role = $_POST['emp_role']; 
        $nic = $_POST['nic']; 

        $profile_picture = null;
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            // Assuming you want to read the file content directly
            $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);
        }
        // No need for try-catch if not throwing exceptions within the logic
        $updateSuccess = $userManager->updateEmployee($staff_id, $name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $role, $nic, $profile_picture);
        
        if ($updateSuccess) {
            header('Location: ../views_manager/staff_center.php');
            exit;
        } else {
            // Log error or handle unsuccessful update attempt
            error_log("Error in updating staff");
            header('Location: ../views_manager/edit_staff.php?update=failed');
            exit;
        }
    }
}

