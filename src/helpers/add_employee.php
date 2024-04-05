<?php
session_start(); // Ensure session start at the beginning of the script
require_once '../classes/database.php'; 
require_once '../classes/UserManager.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userManager = new UserManager();

    $form_mode = $_POST['form_mode'];

    // Base redirection path
    $redirectPath = '../views_manager/';

    // Validate input data and perform operations...

    if ($form_mode == 'add') {
        // Attempt to add the user
        // Set redirection path for adding
        $redirectPath .= 'add_staff.php'; // Redirect to staff center after adding
    } else if ($form_mode == 'edit') {
        // Attempt to update the user
        // Set redirection path for editing
        $redirectPath .= 'edit_success_page.php'; // Redirect to an edit success page or wherever appropriate
    }


    $email = $_POST['email'];
    $user_password = $_POST['user_password'];
    $role = $_POST['role'];
    $nic = $_POST['nic'];
    $staff_name = $_POST['staff_name'];
    $mobile_no = $_POST['mobile_no'];

    // Validate name - must not contain numbers
    if (preg_match('/[0-9]/', $staff_name)) {
        $_SESSION['error'] = 'Name cannot contain numbers.';
        header('Location: ' . $redirectPath);
        exit;
    }

    // Validate mobile number - Sri Lankan mobile numbers (example format: 07XXXXXXXX)
    if (!preg_match('/^07\d{8}$/', $mobile_no)) {
        $_SESSION['error'] = 'Invalid mobile number format.';
        header('Location: ' . $redirectPath);
        exit;
    }

    // Validate NIC - assuming the old format (9 digits followed by X or V) and new format (12 digits)
    if (!preg_match('/^\d{9}[vxVX]$|^\d{12}$/', $nic)) {
        $_SESSION['error'] = 'Invalid NIC format.';
        header('Location: ' . $redirectPath);
        exit;
    }

    // Check if the email already exists
    if ($userManager->emailExists($email)) {
        $_SESSION['error'] = 'Email is already in use.';
        header('Location: ' . $redirectPath);
        exit;
    }

    // Proceed with adding the user after passing all validations

    // Attempt to add the user
    $user_id = $userManager->addUser($email, $user_password, $role);

    if ($user_id) {
        // Additional employee details
        $staff_address = $_POST['staff_address'];
        $alternative_mobile_no = $_POST['alternative_mobile_no'] ?? '';
        $date_of_birth = $_POST['date_of_birth'];
        $sal = $_POST['sal'];
        $profile_picture = null;

        // Profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
            $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);
        }

        // Add employee details
        $result = $userManager->addEmployee($role, $staff_name, $staff_address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $user_id, $nic, $profile_picture);

        if ($result) {
            $_SESSION['message'] = 'New employee added successfully.';
            header('Location: ../views_manager/staff_center.php');
            exit;
        } else {
            // Handling the case where adding the employee details fails
            echo "Failed to add new employee.";
        }
    } else {
        // Handling unexpected failures
        $_SESSION['error'] = 'An unexpected error occurred.';
        header('Location: ' . $redirectPath);
        exit;
    }
}
?>




