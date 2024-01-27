<?php
require_once '../classes/database.php';
require_once '../classes/cart.php';
require_once '../classes/product.php';
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();
$cart = new Cart($db);
$product = new Product($db);

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$orderDetails = $cart->getCartItemsByUserId($userId);
$totalAmount = 0;

function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delivery Details</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/checkout.css">
    
</head>
<body>

<div class="main-header">
    <?php require_once '../components/headers/main_header.php'; ?>
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
                        <?php foreach ($orderDetails as $item): 
                            $productDetails = $product->getProductById($item['product_id']);
                            $subtotal = $productDetails['price'] * $item['quantity'];
                            $totalAmount += $subtotal;
                        ?>
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <?php if ($productDetails['image1']): ?>
                                            <img src="data:image/jpeg;base64,<?= base64_encode($productDetails['image1']) ?>" 
                                            alt="<?= htmlspecialchars($productDetails['product_name']) ?>">
                                        <?php endif; ?>
                                        <h3><?= htmlspecialchars($productDetails['product_name']) ?></h3>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars(formatPrice($productDetails['price'])) ?></td>
                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                <td><?= htmlspecialchars(formatPrice($subtotal)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="total-price-section">
                    <h3>Total Price: <?= formatPrice($totalAmount) ?></h3>
                </div>
            <?php else: ?>
                <p class="not-found">Order items not found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Second Column: Delivery Details -->
    <div class="box-style">
        <h2>Billing Details</h2>
        <form action="../helpers/checkout_handler.php" method="post" class="checkout-form">
            <input type="hidden" name="total_amount" value="<?= htmlspecialchars($totalAmount); ?>">
            <div><input type="text" name="first_name" placeholder="First Name" required></div>
            <div><input type="text" name="last_name" placeholder="Last Name" required></div>
            <div><input type="email" name="email" placeholder="Email" required></div>
            <div><input type="text" name="phone" placeholder="Phone" required></div>
            <div><input type="text" name="province" placeholder="Province" required></div>
            <div><input type="text" name="city" placeholder="City" required></div>
            <div><input type="text" name="delivery_address" placeholder="Delivery Address" required></div>
            <div><input type="text" name="postalcode" placeholder="Postal Code" required></div>
            
            
            <div class="payment-options">
                <h3>Payment Options</h3>
                <div>
                    <input type="radio" id="pay_delivery" name="payment_method" value="pay_on_delivery" checked>
                    <label for="pay_delivery">Pay on Delivery</label>
                </div>
                <div>
                    <input type="radio" id="pay_online" name="payment_method" value="pay_online">
                    <label for="pay_online">Pay Online</label>
                </div>
            </div>
            <div><input type="submit" value="Place Order" class="place-order-button"></div>
        </form>

    </div>
</div>

</body>
</html>
