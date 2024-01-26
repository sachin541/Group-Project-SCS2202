<?php
require_once '../classes/database.php';
require_once '../classes/product.php';
require_once '../classes/InStore.php'; // Update the class import
$database = new Database();
$db = $database->getConnection();

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

$product = new Product($db);
$inStore = new InStore($db); // Use InStore class

$orderDetails = [];

try {
    if (!empty($order_id)) {
        $orderDetails = $inStore->getInStoreOrderDetails($order_id); // Use the InStore function
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}

function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_deliverer/detailsOrder.css">
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_deliverer/progressBar.css"> <!-- Update CSS path -->
</head>
<body>
    <!-- Your HTML and PHP code to display order details goes here -->

    <div class="main-header">
        <?php require_once '../components/headers/main_header.php'; ?>
    </div>

    <!-- Rest of your code to display order details -->
    <!-- You can use $orderDetails to display the order details -->
</body>
</html>

