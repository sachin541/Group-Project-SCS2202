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
        header('Location: ../views_customer/order_success.php?order_id=' . $orderId);
        exit;
    } catch (Exception $e) {
        echo $e;
    }
}

//online payments
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['payment_method'] == "pay_online") {
    try {
        $payment =  $checkout->GetPaymentStatus($_SESSION["new_order_id"]); 

        if($payment){
        unset($_SESSION["new_order_id"]); 
        $orderId = $checkout->createOrderOnline($userId, $_POST, $cartItems);//creates order
        $cart->updateProductQuantities($userId);//updates the qty of the products 
        $cart->clearCart($userId);//clears the cart
        header('Location: ../views_customer/order_success.php?order_id=' . $orderId);
        
        }
        else{
            $_SESSION["payment_error"] = "Payment failed. Please try again"; 
            header('Location: ../views_customer/checkout.php');
            exit;
        }

        
        
        
    } catch (Exception $e) {
        echo $e;
    }
}


?>
