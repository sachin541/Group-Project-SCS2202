<?php
require_once '../classes/customer.php';
require_once '../classes/UserManager.php';
require_once '../ultils/OTP.php'; // Adjust path as needed
require_once '../classes/database.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['verify_otp'])) {
        if (isset($_SESSION['otp'], $_POST['otp']) && $_SESSION['otp'] == $_POST['otp']) {
            $customer = new Customer();
            // Proceed with user registration using the temporarily stored email and password
            $registrationSuccessful = $customer->register_customer($_SESSION['otp_email'], $_SESSION['new_password']);
            
            if ($registrationSuccessful) {
                // Clear session variables upon successful registration
                unset($_SESSION['otp'], $_SESSION['otp_email'], $_SESSION['new_password'], $_SESSION['show_otp_modal']);
                // Optionally, log the user in and redirect to another page or show a success message
                $_SESSION['registration_success'] = 'Registration successful. You can now log in.';
                header('Location: ../views_main/login.php');
                exit;
            } else {
                // Handle case where registration fails
                $_SESSION['registration_error'] = 'Registration failed. Please try again.';
                header('Location: ../views_main/reg.php');
            }
        } else {
            
                $_SESSION['registration_error'] = 'Invalid OTP. Please try again.';
                $_SESSION['otp_error'] = 'Invalid OTP. Please try again.'; // Additional line
                $_SESSION['show_otp_modal'] = 1; 
                header('Location: ../views_main/reg.php');
            
            

        }
    } 


    else {
    // Check if all fields are filled
    if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password_confirmation'])) {
        $_SESSION['registration_error'] = 'Please fill in all required fields.';
        header('Location: ../views_main/reg.php');
        exit;
    }

    $userManager = new UserManager();

    // Check if email already exists
    if ($userManager->emailExists($_POST['email'])) {
        $_SESSION['registration_error'] = 'Email is already in use.';
        header('Location: ../views_main/reg.php');
        exit;
    }

    // Check if passwords match
    if ($_POST['password'] !== $_POST['password_confirmation']) {
        $_SESSION['registration_error'] = 'Passwords do not match.';
        header('Location: ../views_main/reg.php');
        exit;
    }

    // Password strength check
    $password = $_POST['password'];
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';

    if (!preg_match($pattern, $password)) {
        $_SESSION['registration_error'] = 'Weak Password.';
        header('Location: ../views_main/reg.php');
        exit;
    }

    // Generate OTP
    $otp = rand(100000, 999999); // Consider a more secure OTP generation method

    // Send OTP via email
    // Send OTP via email

    $sendStatus = sendOtpEmail($_POST['email'], $otp);
    // for testing
    // $otp= 102; 
    // $sendStatus = true; 

    if ($sendStatus === true) {
        // Store OTP and email in session for verification
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $_POST['email'];
        $_SESSION['new_password'] = $_POST['password'];
        $_SESSION['show_otp_modal'] = true; // Indicate that the OTP modal should be shown
        header('Location: ../views_main/reg.php');
        exit;
    } else {
        // Handle email sending failure
        $_SESSION['registration_error'] = "Failed to send OTP. Error: $sendStatus";
        header('Location: ../views_main/reg.php');
        exit;
    }
    }
}
?>


