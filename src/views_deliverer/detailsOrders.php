<?php
require_once '../classes/database.php';
require_once '../classes/product.php';
require_once '../classes/order.php'; 
require_once '../components/headers/main_header.php';
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'deliverer' )){
    header('Location: ../views_main/denied.php');
    exit;
}
$database = new Database();
$db = $database->getConnection();

// $order_id = $_POST['order_id'];
$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : (isset($_GET['order_id']) ? $_GET['order_id'] : '');

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

// echo '<pre>' . print_r($orderDetails, true) . '</pre>';
function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}

function formatAndCapitalize($str) {
    // Replace all underscores with spaces
    $str = str_replace('_', ' ', $str);
    
    // Capitalize the first letter of each word
    $str = ucwords($str);
    
    return $str;
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
    <?php ?>
</div>

<div class="grid-container">
    <!-- First Column: Order Items -->
    <div class="box-style">
        <h2 class="components-heading">Order Items</h2>
        <div class="components-section">
            
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
                        <?php foreach ($orderDetails as $item): 
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
            <?php if (!empty($orderDetails)): 
                $firstItem = $orderDetails[0];
                $currentStep = $firstItem['delivery_status'];
            ?>
            <div class="details-flex-container">
                <div class="details-group">
                    <div class="detail"><strong>Order ID:</strong> <?= htmlspecialchars($firstItem['order_id']) ?></div>
                    <div class="detail"><strong>Order Date:</strong> <?= htmlspecialchars(date("d-m-Y", strtotime($firstItem['created_at']))) ?></div>
                   
                </div>
                <div class="details-group">
                    
                    <div class="detail"><strong>E-mail:</strong> <?= htmlspecialchars($firstItem['email']) ?></div>
                    <div class="detail"><strong>Recipient Name:</strong> <?= htmlspecialchars($firstItem['first_name'] . " " . $firstItem['last_name']) ?></div>
                </div>
                <div class="details-group">
                    <div class="detail"><strong>Phone:</strong> <?= htmlspecialchars($firstItem['phone']) ?></div>
                    <div class="detail"><strong>Province:</strong> <?= htmlspecialchars($firstItem['province']) ?></div>
                    <div class="detail"><strong>City:</strong> <?= htmlspecialchars($firstItem['city']) ?></div>
                    <div class="detail"><strong>Delivery Address:</strong> <?= htmlspecialchars($firstItem['delivery_city_address']) ?></div>
                    <div class="detail"><strong>postal Code:</strong> <?= htmlspecialchars($firstItem['postalcode']) ?></div>
                </div>
                <div class="details-group">
                    
                    <div class="detail"><strong>Payment Type:</strong> <?= htmlspecialchars(formatAndCapitalize($firstItem['payment_type'])) ?></div>
                    <div class="detail"><strong>Payment Status:</strong> <?= htmlspecialchars($firstItem['payment_status']) ?></div>
                </div>
            </div>
            <?php else: ?>
            <p class="not-found">Delivery details not found.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="action-section">
        <h2 class="delivery-status">Delivery Status</h2>
        <div class="progress-container">
            <ul class="progressbar">
                <li class="<?= ($currentStep == 'Order Placed' || $currentStep == 'Accepted' || $currentStep == 'Preparing' || $currentStep == 'On The Way' || $currentStep == 'Completed') ? 'completed' : '' ?>">
                    <img src="../../resources/images/progress_icons/order_placed.png" alt="Order Placed">
                    <span>Order Placed</span>
                </li>
                <li class="<?= ($currentStep == 'Accepted' || $currentStep == 'Preparing' || $currentStep == 'On The Way' || $currentStep == 'Completed') ? 'completed' : '' ?>">
                    <img src="../../resources/images/progress_icons/accepted.png" alt="Accepted">
                    <span>Accepted</span>
                </li>
                <li class="<?= ($currentStep == 'Preparing' || $currentStep == 'On The Way' || $currentStep == 'Completed') ? 'completed' : '' ?>">
                    <img src="../../resources/images/progress_icons/preparing.png" alt="Preparing">
                    <span>Preparing</span>
                </li>
                <li class="<?= ($currentStep == 'On The Way' || $currentStep == 'Completed') ? 'completed' : '' ?>">
                    <img src="../../resources/images/progress_icons/on_the_way.png" alt="On The Way">
                    <span>On The Way</span>
                </li>
                <li class="<?= ($currentStep == 'Completed') ? 'completed' : '' ?>">
                    <img src="../../resources/images/progress_icons/completed.png" alt="Completed">
                    <span>Completed</span>
                </li>
            </ul>
        </div>

        <div class="accept-button-container">
            <form action="../helpers/deliveryOrder.php" method="POST">
                <input type="hidden" name="handler_type" value="progress_order">
                <input type="hidden" name="delivery_status" value="<?= htmlspecialchars($currentStep) ?>">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
                <!-- <?php echo $currentStep; ?> -->
                <?php if ($currentStep == 'Order Placed'): ?>
                    <button type="submit" class="accept-button">Accept Delivery</button>
                <?php elseif ($currentStep == 'Accepted' || $currentStep == 'Preparing' || $currentStep == 'On The Way'): ?>
                    <button type="submit" class="accept-button">Next Stage</button>
                <?php elseif ($currentStep == 'On The Way'): ?>
                    <button type="submit" class="accept-button">Complete</button>
                <?php endif; ?>
            </form>
        </div>

    </div>
</div>

</body>
</html>



