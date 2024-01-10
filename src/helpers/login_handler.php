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

        if($_SESSION['role'] == 'technician'){
            header('Location: ../views_tech/technician_home.php');
        }
        else if($_SESSION['role'] == 'manager'){
            header('Location: ../views_manager/manager_home.php');
        }
        else if($_SESSION['role'] == 'staff'){
            header('Location: ../views_staff/staff_home.php');
        }
        else if($_SESSION['role'] == 'deliverer'){
            header('Location: ../views_deliverer/deliverer_home.php');
        }
        else{
            header('Location: ../views_main/home.php');
        }  
    } else {
        $_SESSION['error_message'] = 'Incorrect username or password';
        header('Location: ../views_main/login.php');
        exit;
        
    }
}



?>