<?php
require_once '../classes/database.php';
require_once '../classes/product.php';
require_once '../classes/InStore.php';
require_once '../classes/UserManager.php';

$database = new Database();
$db = $database->getConnection();

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

$product = new Product($db);
$inStore = new InStore($db);
$managerobj = new UserManager();
$orderDetails = [];

try {
    if (!empty($order_id)) {
        $orderDetails = $inStore->getInStoreOrderDetails($order_id);
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
// print_r($orderDetails);
function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delivery Details</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_deliverer/detailsOrder.css">
    
</head>
<body>
<div class="main-header">
    <?php require_once '../components/headers/main_header.php';?>
</div>

<div class="grid-container">
    <!-- First Column: Order Items -->
    <div class="box-style">
        <div class="components-section">
            <h2 class="components-heading">Order Items</h2>
            <div class="components-list">
                <?php if (!empty($orderDetails)): ?>
                    <?php foreach ($orderDetails as $item): ?>
                        <?php $productDetails = $product->getProductById($item['product_id']); ?>
                        <div class="component-item">
                            <?php if ($productDetails['image1']) { ?>
                                <img class="component-image" src="data:image/jpeg;base64,<?= base64_encode($productDetails['image1']) ?>" 
                                alt="<?= htmlspecialchars($productDetails['product_name']) ?>">
                            <?php } ?>
                            <div class="component-details">
                                <p class="component-name"><?= htmlspecialchars($item['product_name']) ?></p>
                                <p class="component-price">Quantity: <?= htmlspecialchars($item['item_quantity']) ?></p>
                                <p class="component-item-price">Unit Price: <?= formatPrice($productDetails['price']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="not-found">Order items not found.</p>
                <?php endif; ?>
            </div>
            <?php if (!empty($orderDetails)): ?>
                <div class="total-price-section">
                    <h3>Total Price:</h3>
                    <p><?= formatPrice($orderDetails[0]['total']) ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Second Column: Delivery Details -->
    <div class="box-style">
        <div class="delivery-details">
            <h2 class="components-heading">Order Details</h2>
            <?php if (!empty($orderDetails)): ?>
                <?php $firstItem = $orderDetails[0]; ?>
                <table class="details-table">
                    <tr>
                        <td>Order ID:</td>
                        <td><?= htmlspecialchars($firstItem['order_id']) ?></td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td><?= htmlspecialchars(formatPrice($firstItem['total'])) ?></td>
                    </tr>
                    <tr>
                        <td>Order Date:</td>
                        <td><?= htmlspecialchars(date("d-m-Y", strtotime($firstItem['created_at']))) ?></td>
                    </tr>
                    <tr>
                        <td>Created By (User ID):</td>
                        <td><?= htmlspecialchars($firstItem['createdby']) ?></td>
                    </tr>
                    <tr>
                        <td>Payment Type:</td>
                        <td><?= htmlspecialchars($firstItem['payment_type']) ?></td>
                    </tr>
                    <tr>
                        <td>Payment Status:</td>
                        <td><?= htmlspecialchars($firstItem['payment_status'] . " (In Store)") ?></td>
                    </tr>
                    <tr>
                        <td>NIC:</td>
                        <td><?= htmlspecialchars($firstItem['NIC']) ?></td>
                    </tr>
                    <tr>
                        <td>Recipient Name:</td>
                        <td><?= htmlspecialchars($firstItem['first_name'] . " " . $firstItem['last_name']) ?></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><?= htmlspecialchars($firstItem['phone']) ?></td>
                    </tr>
                </table>

            <?php else: ?>
                <p class="not-found">Delivery details not found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>



