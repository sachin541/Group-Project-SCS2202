<?php
require_once '../classes/database.php';
require_once '../classes/order.php'; // Use your actual Order class

$database = new Database();
$db = $database->getConnection();

$orderManager = new Order($db); // Initialize OrderManager with DB connection

$orderDetails = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $orderDetails = $orderManager->getOrderDetails($orderId); // Fetch details for the specific order
} else {
    // Handle the case where order_id is not set or the method is not POST
    echo "Order ID not provided.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_deliverer/acceptOrder.css"> <!-- Update the path as needed -->
</head>
<body>
    <div class="order-details-container">
        <h1>Order Details</h1>

        <?php if (!empty($orderDetails)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderDetails as $key => $value): ?>
                        <tr>
                            <td><?= htmlspecialchars($key) ?></td>
                            <td><?= htmlspecialchars($value) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Order details not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
