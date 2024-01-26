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
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/confirmOrder.css" /> 
</head>
<body>
    <div class="checkout-container">
        

        <div class="cart-container">
            <h2>Order Details</h2>
            <table class="cart-summary">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
                <?php
                foreach ($cartItems as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $totalAmount += $subtotal;
                    ?>
                    <tr>
                        <td class="product-info">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image1']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                            <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                        </td>
                        <td><?php echo htmlspecialchars(number_format($item['price'],2)); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($subtotal,2)); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="total-label">Total:</td>
                    <td class="total-amount">Rs.<?php echo htmlspecialchars(number_format($totalAmount, 2)); ?></td>
                </tr>
            </table>
        </div>

        <div class="checkout-form-container">
            <h2>Customer Details</h2>
            <form action="../helpers/checkout_handler.php" method="post" class="checkout-form">
                <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($totalAmount); ?>">
                <div><input type="text" name="first_name" placeholder="First Name" required></div>
                <div><input type="text" name="last_name" placeholder="Last Name" required></div>
                <!-- <div><input type="email" name="email" placeholder="Email" required></div> -->
                <div><input type="text" name="phone" placeholder="Phone" required></div>
                <!-- <div><input type="text" name="delivery_address" placeholder="Delivery Address" required></div>
                <div><input type="text" name="postalcode" placeholder="Postal Code" required></div>
                <div><input type="text" name="province" placeholder="Province" required></div>
                <div><input type="text" name="city" placeholder="City" required></div> -->
                
            
                <div class="payment-options">
                    <h3>Payment Options</h3>
                    <div>
                        <input type="radio" id="pay_delivery" name="payment_method" value="pay_on_delivery" checked>
                        <label for="pay_delivery">Pay by Card</label>
                    </div>
                    <div>
                        <input type="radio" id="pay_online" name="payment_method" value="pay_online">
                        <label for="pay_online">Pay by Cash</label>
                    </div>
                </div>

                <div class="placeOrderbtn"><input type="submit" value="Place Order" class="place-order-button"></div>
            </form>
        </div>
    </div>
</body>
</html>
