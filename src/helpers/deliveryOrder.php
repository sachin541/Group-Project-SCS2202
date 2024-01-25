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
                $orderId = $_POST['order_id'];
                $deliveryPersonId = $_SESSION['user_id'];
                $completedDate = NULL; 
                $status = "Accepted";

                
                try {
                    $result = $deliveryObj->acceptDelivery($orderId, $deliveryPersonId, $completedDate, $status);
                    echo $result ? "Order Accepted Successfully" : "Failed to Accept Order";

                } catch (Exception $e) {
                    // Handle any exceptions here
                    echo $e;
                }
                break;

            case 'update_delivery':
                // Implementation for update_delivery
                break;

            case 'remove_delivery':
                // Implementation for remove_delivery
                break;

            case 'create_new_delivery':
                // Implementation for create_new_delivery
                break;
        }
    }
    exit;
}




