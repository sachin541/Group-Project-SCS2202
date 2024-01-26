<?php
require_once '../classes/database.php'; 
require_once '../classes/InStore.php';
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();
$inStore = new InStore($db);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$cartItems = $inStore->getInStoreItemsByUserId($userId);
$totalAmount = 0; 
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/checkoutnew.css" /> 
</head>
<body>
    <div class="checkout-container">
        <h1>Checkout</h1>

        <div class="cartItems">
            <div class="cart-summary">
                <h2>Your Order</h2>
                <ul>
                    <?php
                    
                    foreach ($cartItems as $item) {
                        $subtotal = $item['price'] * $item['quantity'];
                        $totalAmount += $subtotal;
                        echo "<li>" . htmlspecialchars($item['product_name']) . " - Rs." . htmlspecialchars($item['price']) . " x " . htmlspecialchars($item['quantity']) . "</li>";
                    }
                    ?>
                    <li><strong>Total: Rs.<?php echo htmlspecialchars(number_format($totalAmount, 2)); ?></strong></li>
                </ul>
            </div>
        </div>

        <div class="formContainer">
            <form action="../helpers/checkout_handler.php" method="post" class="checkout-form">
                <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($totalAmount); ?>">
                <div><input type="text" name="first_name" placeholder="First Name" required></div>
                <div><input type="text" name="last_name" placeholder="Last Name" required></div>
                <div><input type="email" name="email" placeholder="Email" required></div>
                <div><input type="text" name="phone" placeholder="Phone" required></div>
                <div><input type="text" name="delivery_address" placeholder="Delivery Address" required></div>
                <div><input type="text" name="postalcode" placeholder="Postal Code" required></div>
                <div><input type="text" name="province" placeholder="Province" required></div>
                <div><input type="text" name="city" placeholder="City" required></div>
                
            
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