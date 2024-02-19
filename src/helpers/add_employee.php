<?php
require_once '../classes/database.php'; 
require_once '../classes/UserManager.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userManager = new UserManager();

    // Process form data
    $email = $_POST['email'];
    $user_password = $_POST['user_password'];
    $role = $_POST['role'];
    $nic = $_POST['nic']; // Assuming you have an input for NIC in your form

    // Attempt to add the user
    $user_id = $userManager->addUser($email, $user_password, $role);

    if ($user_id) {
        // Extract additional employee information from $_POST
        $staff_name = $_POST['staff_name'];
        $staff_address = $_POST['staff_address'];
        $mobile_no = $_POST['mobile_no'];
        $alternative_mobile_no = $_POST['alternative_mobile_no'];
        $date_of_birth = $_POST['date_of_birth'];
        $sal = $_POST['sal'];

        // Initialize $profile_picture as NULL
        $profile_picture = null;

        // Check if a file was uploaded without error
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
            // Process the profile picture
            $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);
        }

        // Add the employee, including NIC and the profile picture (if any)
        $result = $userManager->addEmployee($role, $staff_name, $staff_address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $user_id, $nic, $profile_picture);

        if ($result) {
            $_SESSION['message'] = 'New employee added successfully.';
            header('Location: ../views_manager/staff_center.php');  // Redirect to a success page
        } else {
            echo "Failed to add new employee.";
        }
    } else {
        $_SESSION['error'] = 'Failed to add user. Email might already be in use.';
        header('Location: ../views_manager/add_staff.php'); // Redirect to an error handling page
    }
}


