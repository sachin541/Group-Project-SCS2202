<?php
require_once '../classes/users.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User();
    $loginResult = $user->login($_POST['email'], $_POST['password']);
    $userId = $loginResult['id'];
    if ($userId) {
        
        $_SESSION['user_id'] = $loginResult['id'];
        $_SESSION['role'] = $loginResult['role'];

        echo 'Login successful!';
        header('Location: ../pages/home.php');
        
    } else {
        $_SESSION['error_message'] = 'Incorrect username or password';
        header('Location: ../pages/login.php');
        exit;
        
    }
}
?>