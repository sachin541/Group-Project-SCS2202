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
$totalAmount = 0; //used in loop later to cal total in cart
// Page content starts here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/cartnew.css" />
</head>
<body>
    <div class="cart-container">
        <h1>Your Cart</h1>
        <?php foreach ($cartItems as $item): ?>
            <?php $subtotal = $item['price'] * $item['quantity'];
                $totalAmount += $subtotal; ?>
            <div class="cart-item">
                <div class="details">
                    <div><h3><?php echo htmlspecialchars($item['product_name']); ?></h3></div>
                    <!-- <div><p><?php echo htmlspecialchars($item['product_description']); ?></p></div> -->
                    
                    <div><p>Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p></div>
                    <div><p>Sub Total: Rs.<?php echo htmlspecialchars($item['price']*$item['quantity']); ?></p></div>
                    <div><p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p></div>
                </div>

                    <!-- Update QTY -->
                <div class="quantity-controls">
                    <form action="../helpers/cart_handler.php" method="post" id="update-form-<?php echo $item['id']; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="update_cart_qty" value="True">
                        <button type="button" onclick="decreaseQuantity(<?php echo $item['id']; ?>)">-</button>
                        <input type="text" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                        <button type="button" onclick="increaseQuantity(<?php echo $item['id']; ?>)">+</button>
                        <!-- <input type="submit" value="Update"> -->
                    </form>
                </div>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image1']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                        <!-- Delete button form -->
                <form action="../helpers/cart_handler.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="remove_from_cart" value="True">
                    <input type="submit" value="Remove" class="delete-button">
                </form>

                <!-- Display Total Amount -->
               

                <!-- <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image1']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>"> -->
                <!-- You can add more elements here like remove button, etc. -->
            </div>
        <?php endforeach; ?>
        <div class="cart-total">
                    <h2>Total: Rs.<?php echo htmlspecialchars(number_format($totalAmount, 2)); ?></h2>
                </div>
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

