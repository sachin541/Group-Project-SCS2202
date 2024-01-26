<?php
require_once '../classes/database.php'; 
require_once '../classes/InStore.php';
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();
$inStore = new InStore($db);

// Check if the user (staff) is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/staff_login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$cartItems = $inStore->getInStoreItemsByUserId($userId);
$totalAmount = 0; // Used in loop later to calculate total

function formatPrice($price) {
    return number_format($price, 2, '.', ',') ;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/InStoreOrder.css" />
</head>
<body>
    <div class="cart-container">
        <h1>Create New Order</h1>

        <?php if (empty($cartItems)): ?>
            <p class="empty-cart-message">Your cart is empty.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Update Quantity</th>
                        <th>Remove</th>
                        <th>Sub Total (RS.)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <?php 
                        $subtotal = $item['price'] * $item['quantity'];
                        $totalAmount += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <div class="product-info">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image1']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                                    <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                                    
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars(formatPrice($item['price'])); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            
                            <td>
                            <div class="quantity-controls"> 
                                <form action="../helpers/InStoreHandler.php" method="post" id="update-form-<?php echo $item['id']; ?>">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="update_instore_qty" value="True">
                                    <button type="button" onclick="decreaseQuantity(<?php echo $item['id']; ?>)">-</button>
                                    <input type="text" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                                    <button type="button" onclick="increaseQuantity(<?php echo $item['id']; ?>)">+</button>
                                </form>
                            </div>
                            </td>
                            <td>
                                <form action="../helpers/InStoreHandler.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="remove_from_instore" value="True">
                                    <input type="submit" value="Remove" class="delete-button">
                                </form>
                            </td>
                            <td><?php echo htmlspecialchars(formatPrice($subtotal)); ?></td>
                        </tr>
                        
                    <?php endforeach; ?>
                    <tr class="last-row">
                        <td colspan="6" class="add-more-container">
                            <a href="./product_list.php" class="add-more-link">
                                <img src="../../resources/images/icons/addmore.png" alt="Add More Products">
                                <span>Add More Products</span>
                            </a>
                        </td>
                    </tr>
                </tbody>

            </table>
            
            <div class="cart-total">
                <h2>Total: <?php echo htmlspecialchars(formatPrice($totalAmount)); ?></h2>

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

                <!-- <form action="../helpers/cart_transaction_handler.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                    <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($totalAmount); ?>">
                    <input type="submit" value="Create Order" class="checkout-button">
                </form> -->

                <a href="./confirmOrder.php" class="add-more-link">
                    <span>Create Order</span>
                </a>

                
                        

                        
                
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