<?php
require_once '../classes/database.php';
require_once '../classes/cart.php';
require_once '../classes/Checkout.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$database = new Database();
$db = $database->getConnection();
$cart = new Cart($db);
$checkout = new Checkout($db);


$cartItems = $cart->getCartItemsByUserId($userId);

//payment on delivery 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['payment_method'] == "pay_on_delivery") {
    try {
        // Process the order
        $orderId = $checkout->createOrder($userId, $_POST, $cartItems);//creates order
        $cart->updateProductQuantities($userId);//updates the qty of the products 
        $cart->clearCart($userId);//clears the cart
        //cocurrency issues 
        header('Location: ../pages/order_success.php?order_id=' . $orderId);
        exit;
    } catch (Exception $e) {
        echo $e;
    }
}

//online payments
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['payment_method'] == "pay_online") {
    try {
        echo "Not done"; 
    } catch (Exception $e) {
        echo $e;
    }
}
?>
