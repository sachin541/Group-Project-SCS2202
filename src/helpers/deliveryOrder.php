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
            case 'progress_order':
                $orderId = $_POST['order_id'];
                $currentStatus = $_POST['delivery_status']; // Get the current status
                $deliveryPersonId = $_SESSION['user_id'];
                // Determine the next status based on the current status
                $nextStatus = '';
                if ($currentStatus == 'Order Placed') {
                    $nextStatus = 'Accepted';
                    $status = "Accepted";
                    $result = $deliveryObj->CreateDelivery($orderId, $deliveryPersonId, NULL, $status);
                } elseif ($currentStatus == 'Accepted') {
                    $nextStatus = 'Preparing';
                } elseif ($currentStatus == 'Preparing') {
                    $nextStatus = 'On The Way';
                } elseif ($currentStatus == 'On The Way') {
                    $nextStatus = 'Completed';
                }

                if (!empty($nextStatus) || $currentStatus == 'Order Placed') {
                    try {
                        $result = $deliveryObj->progressDeliveryStage($orderId, $nextStatus);
                        echo "Order status updated to: $nextStatus";
                        header('Location: ../views_deliverer/detailsOrders.php?order_id=' . urlencode($orderId));
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } else {
                    echo "Invalid current status.";
                }
                break;

            // ... Other cases ...
        }
    }
    exit;
}



                
                