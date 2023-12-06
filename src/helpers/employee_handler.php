<?php
require_once '../classes/database.php'; 
require_once '../classes/UserManager.php'; 

$database = new Database();
$db = $database->getConnection(); 
$userManager = new UserManager();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['handler_type'] == "remove_staff") {
    $id = $_POST['id'];

   
    if ($userManager->deleteEmployee($id)) {
        
        header('Location: ../pages/staff_center.php');
        exit;
    } 


}