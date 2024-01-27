<?php
require_once '../classes/database.php'; 
require_once '../classes/cart.php';
require_once '../components/headers/main_header.php';

function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
  }

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
                        <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                        <p>Price: <?php echo htmlspecialchars(formatPrice($item['price'])); ?></p>
                        <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                        <p>Sub Total: <?php echo htmlspecialchars(formatPrice($subtotal)); ?></p>
                    </div>
                    
                    <div class="quantity-controls">
                        <form action="../helpers/cart_handler.php" method="post" id="update-form-<?php echo $item['id']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="update_cart_qty" value="True">
                            <button type="button" onclick="decreaseQuantity(<?php echo $item['id']; ?>)">-</button>
                            <input type="text" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                            <button type="button" onclick="increaseQuantity(<?php echo $item['id']; ?>)">+</button>
                        </form>
                    </div>

                    <form action="../helpers/cart_handler.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="remove_from_cart" value="True">
                        <input type="submit" value="Remove" class="delete-button">
                    </form>
                </div>
            <?php endforeach; ?>

            <div class="cart-total">
                <h2>Total: <?php echo htmlspecialchars(formatPrice($totalAmount, 2)); ?></h2>

                <?php if (isset($_SESSION['out_of_stock_message'])): ?>
                    <div class='out-of-stock-message'>
                        <p>The following items are out of stock or do not have enough quantity:</p>
                        <?php foreach (explode(", ", $_SESSION['out_of_stock_message']) as $item): ?>
                            <?php echo htmlspecialchars($item) . "<br>"; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['out_of_stock_message']); ?>
                <?php endif; ?>

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

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.cart-container {
    width: 80%;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.cart-container h1 {
    text-align: center;
    color: #333;
}

.cart-item {
    display: flex;
    align-items: center;
    background-color: #f9f9f9; /* Lighter shade of white */
    border-radius: 8px; /* Rounded corners */
    margin-bottom: 10px; /* Space between items */
    padding: 10px;
    transition: box-shadow 0.3s ease, transform 0.3s ease; /* Smooth transition for hover effect */
}

.cart-item:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Enhanced hover effect */
    transform: scale(1.01); /* Slightly scale up on hover */
}

.cart-item:hover {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Hover effect */
}

.cart-item img {
    border-radius: 8px; /* Rounded corners for images */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for images */
    max-width: 100px;
    max-height: 100px;
    margin-right: 20px;
    object-fit: cover; /* Improves how images fit in the container */
}

.details h3 {
    margin: 0 0 10px 0;
    color: #333;
}

.details p {
    margin: 5px 0;
    color: #666;
}

.quantity-controls {
    margin-left: auto;
}

.quantity-controls input[type="text"] {
    width: 40px;
    text-align: center;
    margin: 0 0px;
    border: 1px solid #ccc; /* Adds a border */
    padding: 5px; /* Adds some padding inside the input box */
    border-radius: 5px; /* Rounded corners to match the buttons */
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); /* Subtle inner shadow for depth */
    outline: none; /* Removes the default focus outline */
}

.quantity-controls input[type="text"]:focus {
    border-color: #000000; /* Changes border color on focus */
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2), 0 0 5px rgba(0, 123, 255, 0.5); /* Enhances shadow on focus */
}

.quantity-controls button, .delete-button {
    background-color: #515151;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px; /* Rounded corners for buttons */
    margin: 5px; /* Adding some margin for spacing */
}

.quantity-controls button:hover {
    background-color: red;
}

.delete-button {
    background-color: #16a085;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.1s ease, transform 0.3s ease; /* Smooth transition for hover effects */
    margin-left: 20px; /* Space from other elements */
}

.delete-button:hover {
    background-color: red; 
    
    
}

.cart-total {
    text-align: right;
    margin-top: 40px;
    margin-bottom: 20px;
    border-bottom: 10px;
    
    
}

.cart-total h2 {
    color: #333;
}

.checkout-button {
    background-color: #000000; /* Green background for checkout button */
    color: white;
    border: none;
    padding: 20px 10px;
    cursor: pointer;
    border-radius: 5px; /* Rounded corners */
    font-size: 26px; /* Larger font size */
    margin-top: 20px; /* Space from the total amount */
    display: block; /* Makes the button block level */
    width: 100%; /* Full width */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    transition: background-color 0.2s ease, transform 0.3s ease;
}

.checkout-button:hover {
    background-color: red; /* Darker shade on hover */
    transform: translateY(-2px); /* Slightly raise the button */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}


.out-of-stock-message {
    background-color: #ffdddd; /* Light red background */
    border: 1px solid #ff0000; /* Red border */
    color: #ff0000; /* Red text color for emphasis */
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.out-of-stock-message p {
    margin: 0 0 10px 0; /* Spacing between the paragraph and the list */
    font-weight: bold; /* Make the introductory text bold */
}

.out-of-stock-message ul {
    list-style-type: none; /* Removes bullet points */
    margin: 0;
    padding-left: 0; 
}

.out-of-stock-message li {
    list-style-type: disc; 
}


.empty-cart-message {
    color: #555;
    background-color: #f2f2f2; 
    border: 1px solid #ddd; 
    padding: 105px;
    margin-top: 100px; 
    text-align: center; 
    border-radius: 5px; 
    font-size: 3.2em; 
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
}




