<?php
require_once '../classes/customer.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['password'], $_POST['password_confirmation']) && $_POST['password'] === $_POST['password_confirmation']) {
        $user = new Customer();
        $registrationSuccessful = $user->register_customer($_POST['email'], $_POST['password']);

        if ($registrationSuccessful) {
            echo 'Registration successful!';
            header('Location: ../views_main/login.php');
            exit; 
        } else {
            $_SESSION['registration_error'] = 'Registration failed. Email may already be in use.';
            header('Location: ../views_main/reg.php');
            exit;
        }
    } else {
        
        $_SESSION['registration_error'] = 'Passwords do not match.';
        header('Location: ../views_main/reg.php');
        exit;
    }
}
?>
