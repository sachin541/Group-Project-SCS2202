<?php
require_once '../classes/database.php'; 
require_once '../classes/cart.php';

session_start();

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);

//Controlling the current state of the cart 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/login.php');
    exit;
}


if (isset($_POST['product_id']) && isset($_POST['remove_from_cart'])) {
    $productId = $_POST['product_id'];

    $userId = $_SESSION['user_id'];
  
    $cart->deleteFromCart($userId, $productId);

   
    header('Location: ../views_customer/view_cart.php');
    exit;
}

if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['update_cart_qty'])) {
    $productId = $_POST['product_id'];

    $quantity = max(1, $_POST['quantity']); // Ensures quantity is at least 1

    $userId = $_SESSION['user_id'];

    
    $cart->updateCartQuantity($userId, $productId, $quantity);

   
    header('Location: ../views_customer/view_cart.php');
    exit;
}

//adding items from product_details_page 
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $userId = $_SESSION['user_id']; 
    
   
    $cart->addToCart($userId, $productId, $quantity);

   
    header('Location: ../views_customer/view_cart.php');
    exit;
}



// Redirect to product list if the required POST data isn't set
header('Location: ../views_customer/product_list.php');
exit;
?>
