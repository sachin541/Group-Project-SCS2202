<?php
session_start(); // Ensure the session is started
require_once '../classes/delivery.php'; // Adjust path and class name as per your setup
require_once '../classes/database.php';

$database = new Database();
$db = $database->getConnection();
$deliveryObj = new Delivery($db); 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    
    if (isset($_POST['handler_type'])) {
        switch ($_POST['handler_type']) {
            case 'accept_order':
                $deliveryObj->CreateDelivery()
                break;

            case 'update_delivery':
                
                break;

            case 'remove_delivery':
                
                break;

            case 'create_new_delivery':
                
                break;

            
        }
    }

    
    header('Location: some_destination_page.php');
    exit;
}



