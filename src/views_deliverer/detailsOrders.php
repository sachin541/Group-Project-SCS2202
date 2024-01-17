<?php
require_once '../classes/database.php';
require_once '../classes/product.php';
require_once '../classes/order.php'; 
$database = new Database();
$db = $database->getConnection();

$order_id = $_POST['order_id'];

$product = new Product($db);
$orderClass = new Order($db);
$orderDetails = [];


try {
    if (!empty($order_id)) {
        $orderDetails = $orderClass->getOrderDetails($order_id);
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
    <title>Delivery Details</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_deliverer/detailsOrder.css"> <!-- Update CSS path -->
</head>
<body>
<div class="main-header">
    <?php require_once '../components/headers/main_header.php';?>
</div>

<div class="grid-container">
    <!-- First Column: Order Items -->
    
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
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="not-found">Order items not found.</p>
                <?php endif; ?>
            </div>
        </div>
    

    <!-- Second Column: Delivery Details -->
    <div class="box-2">
        <div class="delivery-details">
            <h2 class="components-heading">Delivery Details</h2>
            <?php if (!empty($orderDetails)): ?>
                <?php $firstItem = $orderDetails[0]; ?>
                <table class="details-table">
                    <tr>
                        <td>Delivery Address:</td>
                        <td><?= htmlspecialchars($firstItem['delivery_city_address']) ?></td>
                    </tr>
                    <tr>
                        <td>City:</td>
                        <td><?= htmlspecialchars($firstItem['city']) ?></td>
                    </tr>
                    <tr>
                        <td>Province:</td>
                        <td><?= htmlspecialchars($firstItem['province']) ?></td>
                    </tr>
                    <tr>
                        <td>Postal Code:</td>
                        <td><?= htmlspecialchars($firstItem['postalcode']) ?></td>
                    </tr>
                    <!-- Add more rows as needed -->
                </table>
            <?php else: ?>
                <p class="not-found">Delivery details not found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>



