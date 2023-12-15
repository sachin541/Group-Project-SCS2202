<?php
require_once '../classes/database.php'; 
require_once '../classes/cart.php';

session_start();

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/login.php');
    exit;
}


if (isset($_POST['product_id']) && isset($_POST['remove_from_cart'])) {
    $productId = $_POST['product_id'];

    $userId = $_SESSION['user_id'];
    // Delete from cart
    $cart->deleteFromCart($userId, $productId);

    // Redirect back to the cart page
    header('Location: ../views_customer/view_cart.php');
    exit;
}

if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['update_cart_qty'])) {
    $productId = $_POST['product_id'];
    $quantity = max(1, $_POST['quantity']); // Ensures quantity is at least 1
    $userId = $_SESSION['user_id'];

    // Update the cart
    $cart->updateCartQuantity($userId, $productId, $quantity);

    // Redirect back to the cart page
    header('Location: ../views_customer/view_cart.php');
    exit;
}

// Check if the product ID and quantity are set in the POST request
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $userId = $_SESSION['user_id']; 
    
    // Add to cart
    $cart->addToCart($userId, $productId, $quantity);

    // Redirect to cart page
    header('Location: ../views_customer/view_cart.php');
    exit;
}



// Redirect to product list if the required POST data isn't set
header('Location: ../views_customer/product_list.php');
exit;
?>
