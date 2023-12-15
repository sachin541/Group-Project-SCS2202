<?php
require_once '../classes/database.php'; 
require_once '../classes/UserManager.php'; 

$database = new Database();
$db = $database->getConnection(); 
$userManager = new UserManager();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['handler_type'] == "remove_staff") {
    $id = $_POST['id'];

   
    if ($userManager->deleteEmployee($id)) {
        
        header('Location: ../views_manager/staff_center.php');
        exit;
    } 


}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['handler_type'] == "update_staff") {
    
    try {
        $staff_id = $_POST['staff_id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $mobile_no = $_POST['mobile_no'];
        $alternative_mobile_no = $_POST['alternative_mobile_no'];
        $date_of_birth = $_POST['date_of_birth'];
        $sal = $_POST['sal'];

        // Validate input data here if needed

        // Attempt to update the employee
        $updateSuccess = ($userManager->updateEmployee($staff_id, $name, $address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal));

        if ($updateSuccess) {
            // Handle successful update, e.g., redirect or display success message
        } else {
            // Handle failure, e.g., log error, display error message
            throw new Exception("Failed to update employee details.");
        }
    } catch (Exception $e) {
        // Error handling logic here
        error_log("Error in updating staff: " . $e->getMessage());
        // Optionally, display an error message to the user or redirect
    }
}
