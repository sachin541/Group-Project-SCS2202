<?php
require_once '../classes/database.php';
require_once '../classes/product.php';
require_once '../classes/order.php';
require_once '../components/headers/main_header.php'; 
if(!(isset($_SESSION['role'])) || !($_SESSION['role'] != 'manager' || $_SESSION['role'] != 'staff')){
    header('Location: ../views_main/denied.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';


$product = new Product($db);
$inStore = new Order($db);

$orderDetails = [];

try {
    if (!empty($order_id)) {
        $orderDetails = $inStore->getOrderDetails($order_id);
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
// print_r($orderDetails);
// print_r($orderDetails);
function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delivery Details</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/ViewOrderDeliverySub.css">
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_deliverer/progressBar.css">
    
</head>
<body>
<div class="main-header">
    
</div>

<div class="grid-container">
    <!-- First Column: Order Items -->
    <div class="box-style">
        <div class="components-section">
            <h2 class="components-heading">Order Items</h2>

            <?php if (!empty($orderDetails)): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $item): ?>
                            <?php 
                            $productDetails = $product->getProductById($item['product_id']);
                            $subtotal = $productDetails['price'] * $item['item_quantity'];
                            ?>
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <?php if ($productDetails['image1']) { ?>
                                            <img src="data:image/jpeg;base64,<?= base64_encode($productDetails['image1']) ?>" 
                                            alt="<?= htmlspecialchars($productDetails['product_name']) ?>">
                                        <?php } ?>
                                        <h3><?= htmlspecialchars($productDetails['product_name']) ?></h3>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars(formatPrice($productDetails['price'])) ?></td>
                                <td><?= htmlspecialchars($item['item_quantity']) ?></td>
                                <td><?= htmlspecialchars(formatPrice($subtotal)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="total-price-section">
                    <h3>Total Price: <?= formatPrice($orderDetails[0]['total']) ?></h3>
                </div>
            <?php else: ?>
                <p class="not-found">Order items not found.</p>
            <?php endif; ?>
        </div>
    </div>

    

    <!-- Second Column: Delivery Details -->
    <div class="box-style">
        <div class="delivery-details">
            <h2 class="components-heading">Order Details</h2>
            <?php if (!empty($orderDetails)): ?>
                <?php $firstItem = $orderDetails[0]; 
                $currentStep = $firstItem['delivery_status'];
                ?>
                <table class="details-table">
                    <tr>
                        <td>Order ID:</td>
                        <td><?= htmlspecialchars($firstItem['order_id']) ?></td>
                    </tr>
                    <tr>
                        <td>Order Date:</td>
                        <td><?= htmlspecialchars(date("d-m-Y", strtotime($firstItem['created_at']))) ?></td>
                    </tr>
                    <tr>
                        <td>Payment Type:</td>
                        <td><?= htmlspecialchars($firstItem['payment_type']) ?></td>
                    </tr>
                    <tr>
                        <td>Payment Status:</td>
                        <td><?= htmlspecialchars($firstItem['payment_status']) ?></td>
                    </tr>
                    <tr>
                        <td>E-mail:</td>
                        <td><?= htmlspecialchars($firstItem['email']) ?></td>
                    </tr>
                    <tr>
                        <td>Recipient Name:</td>
                        <td><?= htmlspecialchars($firstItem['first_name'] . " " . $firstItem['last_name']) ?></td>
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
                        <td>Delivery Person ID</td>
                        <td><?= htmlspecialchars($firstItem['postalcode']) ?></td>
                    </tr>
                    
                    
                </table>

            <?php else: ?>
                <p class="not-found">Delivery details not found.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="action-section">
        <h2 class="delivery-status">Delivery Status</h2>
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

        

    </div>

</div>
</body>
</html>