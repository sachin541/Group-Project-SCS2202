<?php
require_once '../classes/database.php';
require_once '../classes/order.php'; 
require_once '../components/headers/main_header.php';
if(!isset($_SESSION['role'])){
    header('Location: ../views_main/denied.php');
    exit;
}

$order_id = $_GET['order_id'] ?? ''; // Fallback to an empty string if not set

$database = new Database();
$db = $database->getConnection();

$orderClass = new Order($db);
$orderDetails = $orderClass->getOrderDetails($order_id);

function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/invoice-style.css">
    <style>
        @media print {
            .outer-grid-container {
                display: none;
            }
        }
    </style>
</head>
<div class="main-header">

</div>
<body>
<div class="invoice-container">
    <?php if (!empty($orderDetails)): ?>
        <?php $firstItem = $orderDetails[0]; ?>

        <div class="invoice-header">
            <h1>Invoice for Order #<?= htmlspecialchars($order_id) ?></h1>
        </div>

        <div class="customer-details">
            <table class="details-table">
                <tr><td>Date:</td><td><?= htmlspecialchars($firstItem['created_at']) ?></td></tr>
                <tr><td>Name:</td><td><?= htmlspecialchars($firstItem['first_name']) . ' ' . htmlspecialchars($firstItem['last_name']) ?></td></tr>
                <tr><td>Email:</td><td><?= htmlspecialchars($firstItem['email']) ?></td></tr>
                <tr><td>Phone:</td><td><?= htmlspecialchars($firstItem['phone']) ?></td></tr>
                <tr><td>Delivery Address:</td><td><?= htmlspecialchars($firstItem['delivery_city_address']) ?></td></tr>
                <tr><td>City:</td><td><?= htmlspecialchars($firstItem['city']) ?></td></tr>
                <tr><td>Province:</td><td><?= htmlspecialchars($firstItem['province']) ?></td></tr>
                <tr><td>Postal Code:</td><td><?= htmlspecialchars($firstItem['postalcode']) ?></td></tr>
            </table>
        </div>

        <div class="order-items">
            <h2>Order Items</h2>
            <table class="items-table">
                <tr>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
                <?php foreach ($orderDetails as $item): ?>
                    <?php $itemAmount = $item['price'] * $item['item_quantity']; ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= formatPrice($item['price']) ?></td>
                        <td><?= htmlspecialchars($item['item_quantity']) ?></td>
                        <td><?= formatPrice($itemAmount) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="invoice-footer">
            <p class="total-amount">Total: <?= formatPrice($firstItem['total']) ?></p>
            <button class="print-button" onclick="window.print();">Print Invoice</button>
        </div>

    <?php elseif (isset($errorMessage)): ?>
        <p class="error-message">Error: <?= htmlspecialchars($errorMessage) ?></p>
    <?php else: ?>
        <p class="not-found">Order not found.</p>
    <?php endif; ?>
    
</div>
</body>
</html>

<!-- Delivery Notification Modal -->
<div id="deliveryNotificationModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Order Placed Successfully!</h2>
        <p>Your order has been placed and will be delivered in 2-3 days.</p>
        <button class="modal-button" id="okButton">OK</button>
    </div>
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    // Automatically show the modal
    var modal = document.getElementById("deliveryNotificationModal");
    modal.style.display = "block";

    // Close the modal when the user clicks on <span> (x)
    document.querySelector(".close-modal").onclick = function() {
        modal.style.display = "none";
    };

    // Close the modal on "OK" button click
    document.getElementById("okButton").onclick = function() {
        modal.style.display = "none";
    };

    // Close the modal if the user clicks anywhere outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});
</script>
