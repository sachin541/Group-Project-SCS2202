<?php
require_once '../classes/database.php'; 
require_once '../classes/InStore.php';
require_once '../components/headers/main_header.php';


$database = new Database();
$db = $database->getConnection();
$inStore = new InStore($db);

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/staff_login.php');
    exit;
}

$orders = $inStore->getAllOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/InStoreOrder.css" />
</head>
<body>
    <div class="cart-container">
        <h1>All Orders</h1>

        <?php if (empty($orders)): ?>
            <p class="empty-cart-message">No orders found.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total (RS.)</th>
                        <th>Created At</th>
                        <th>Payment Type</th>
                        <th>Payment Status</th>
                        <th>Customer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['total']); ?></td>
                            <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($order['payment_type']); ?></td>
                            <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
                            <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
