<?php
require_once '../classes/customer.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new Customer();
    $registrationSuccessful = $user->register_customer($_POST['email'], $_POST['password']);

    if ($registrationSuccessful) {
        echo 'Registration successful!';
        header('Location: ../pages/login.php');
    } else {
        echo 'Registration failed.';
        $_SESSION['registration_error'] = 'Registration failed. Email may already be in use.';
        header('Location: ../pages/reg.php');
        exit;
    }
}
?>