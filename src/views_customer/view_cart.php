<?php
require_once '../classes/database.php'; 
require_once '../classes/cart.php';
require_once '../components/headers/main_header.php';



$database = new Database();
$db = $database->getConnection();
$cart = new Cart($db);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$cartItems = $cart->getCartItemsByUserId($userId);
$totalAmount = 0; //used in loop later to calculate total in cart
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/cartnew.css" />
</head>
<body>
    <div class="cart-container">
        <h1>My Cart</h1>

        <?php if (empty($cartItems)): ?>
            <p class="empty-cart-message">Your cart is empty.</p>
        <?php else: ?>
            <?php foreach ($cartItems as $item): ?>
                <?php 
                $subtotal = $item['price'] * $item['quantity'];
                $totalAmount += $subtotal;
                ?>
                <div class="cart-item">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image1']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                    <div class="details">
                        <div><h3><?php echo htmlspecialchars($item['product_name']); ?></h3></div>
                        <div><p>Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p></div>
                        <div><p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p></div>
                        <div><p>Sub Total: Rs.<?php echo htmlspecialchars($item['price']*$item['quantity']); ?></p></div>
                    </div>
                    <!-- Update QTY -->
                    <div class="quantity-controls">
                        <form action="../helpers/cart_handler.php" method="post" id="update-form-<?php echo $item['id']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="update_cart_qty" value="True">
                            <button type="button" onclick="decreaseQuantity(<?php echo $item['id']; ?>)">-</button>
                            <input type="text" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                            <button type="button" onclick="increaseQuantity(<?php echo $item['id']; ?>)">+</button>
                        </form>
                    </div>
                    <!-- Delete button form -->
                    <form action="../helpers/cart_handler.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="remove_from_cart" value="True">
                        <input type="submit" value="Remove" class="delete-button">
                    </form>
                </div>
            <?php endforeach; ?>

            <div class="cart-total">
                <h2>Total: Rs.<?php echo htmlspecialchars(number_format($totalAmount, 2)); ?></h2>

                <?php
                if (isset($_SESSION['out_of_stock_message'])) {
                    $outOfStockItems = explode(", ", $_SESSION['out_of_stock_message']);
                    echo "<div class='out-of-stock-message'>";
                    echo "<p>The following items are out of stock or do not have enough quantity:</p>";
                    foreach ($outOfStockItems as $item) {
                        echo htmlspecialchars($item) . "<br>";
                    }
                    echo "</div>";
                    unset($_SESSION['out_of_stock_message']);
                }
                ?>

                <form action="../helpers/cart_transaction_handler.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                    <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($totalAmount); ?>">
                    <input type="submit" value="Checkout" class="checkout-button">
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>


<script>
    
function increaseQuantity(productId) {
    var form = document.getElementById('update-form-' + productId);
    var quantityInput = form.querySelector('input[name="quantity"]');
    quantityInput.value = parseInt(quantityInput.value) + 1;
    form.submit();
}

function decreaseQuantity(productId) {
    var form = document.getElementById('update-form-' + productId);
    var quantityInput = form.querySelector('input[name="quantity"]');
    if (parseInt(quantityInput.value) > 1) { // Prevents quantity from going below 1
        quantityInput.value = parseInt(quantityInput.value) - 1;
        form.submit();
    }
}
</script>

