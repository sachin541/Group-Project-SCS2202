<?php
require_once '../classes/database.php'; 
require_once '../classes/UserManager.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userManager = new UserManager();
    $email = $_POST['email'];
    $user_password = $_POST['user_password'];
    $role = $_POST['role'];

    // Insert user data into the `users` table
    $user_id = $userManager->addUser($email, $user_password, $role);

    if ($user_id) {
        $staff_name = $_POST['staff_name'];
        $staff_address = $_POST['staff_address'];
        $mobile_no = $_POST['mobile_no'];
        $alternative_mobile_no = $_POST['alternative_mobile_no'];
        $date_of_birth = $_POST['date_of_birth'];
        $sal = $_POST['sal'];



        $result = $userManager->addEmployee($role , $staff_name, $staff_address, $mobile_no, $alternative_mobile_no, $date_of_birth, $sal, $user_id);
       

        if ($result) {
            echo "New employee added successfully.";
            header('Location: ../pages/home.php'); //change this later ------------
        } else {
            echo "Failed to add new employee.";
        }
    } else {
        //echo "Failed to add user.";
        session_start();
        $_SESSION['add_staff_error'] = 'Failed to add user. Email already in use.';
        header('Location: ../pages/add_staff.php');
        exit;
    }
}
