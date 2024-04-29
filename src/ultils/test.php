<?php
require_once '../classes/customer.php';
require_once '../classes/UserManager.php';

require_once '../classes/database.php'; 
session_start(); 

$database = new Database();
$db = $database->getConnection();
$cus = new Customer();

if(isset($_GET['email']) && isset($_GET['pass'])){
$email = $_GET['email']; 
$pass = $_GET['pass']; 
$cus->new_password($email,$pass); 

}

if(isset($_GET['id']) && isset($_GET['newemail'])){
    $id = $_GET['id']; 
    $email = $_GET['newemail']; 
    $cus->new_email($email,$id); 
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="get">
    EMAIL<input type="text" name="email">
    PASS<input type="text" name="pass" id="">
    <input type="submit" name="SUBMIT" id="">

    <form action="" method="get">
    ID<input type="text" name="id">
    EMAIL<input type="text" name="newemail" id="">
    <input type="submit" name="SUBMIT" id="">
</form>
</body>
</html>
