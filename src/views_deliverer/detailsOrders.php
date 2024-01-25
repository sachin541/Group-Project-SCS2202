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

$currentStep= 'Order Placed';

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
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_deliverer/detailsOrder.css">
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_deliverer/progressBar.css"> <!-- Update CSS path -->
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
                                <!-- Add price for each item -->
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
            <h2 class="components-heading">Delivery Details</h2>
            <?php if (!empty($orderDetails)): ?>
                <?php $firstItem = $orderDetails[0]; ?>
                <table class="details-table">
                    <tr>
                        <td>Recipient Name:</td>
                        <td><?= htmlspecialchars($firstItem['first_name'] . " " . $firstItem['last_name']) ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?= htmlspecialchars($firstItem['email']) ?></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><?= htmlspecialchars($firstItem['phone']) ?></td>
                    </tr>
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
                    <tr>
                    <td>Payment Type:</td>
                    <td>
                        <?php
                        
                        if ($firstItem['payment_type'] === 'pay_on_delivery') {
                            echo 'Pay on Delivery';
                        } else if ($firstItem['payment_type'] === 'payed_online') {
                            echo 'Paid Online';
                        } else {
                            echo 'Unknown'; 
                        }
                        ?>
                    </td>
                </tr>
                    
                </table>

                
            <?php else: ?>
                <p class="not-found">Delivery details not found.</p>
            <?php endif; ?>

                
            


        </div>
    </div>

    <div class="action-section">
        <!-- Accept Delivery Button --><!-- Progress Bar -->
        <div class="progress-container">
            <ul class="progressbar">
                    <li class="<?= ($currentStep == 'Order Placed' || $currentStep == 'Accepted' || $currentStep == 'Preparing' || $currentStep == 'On The Way' || $currentStep == 'Completed') ? 'completed' : '' ?>">Order Placed</li>
                    <li class="<?= ($currentStep == 'Accepted' || $currentStep == 'Preparing' || $currentStep == 'On The Way' || $currentStep == 'Completed') ? 'completed' : '' ?>">Accepted</li>
                    <li class="<?= ($currentStep == 'Preparing' || $currentStep == 'On The Way' || $currentStep == 'Completed') ? 'completed' : '' ?>">Preparing</li>
                    <li class="<?= ($currentStep == 'On The Way' || $currentStep == 'Completed') ? 'completed' : '' ?>">On The Way</li>
                    <li class="<?= ($currentStep == 'Completed') ? 'completed' : '' ?>">Completed</li>
                </ul>
        </div>

        <div class="accept-button-container">
            <form action="../helpers/deliveryOrder.php" method="POST">
                <input type="hidden" name="handler_type" value="accept_order">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
                <button type="submit" class="accept-button">Accept Delivery</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>



