<?php

// require_once '../../config.php';
require_once '../classes/checkout.php';
require_once '../classes/database.php';

$database = new Database();
$db = $database->getConnection();
$checkout = new Checkout($db);

$merchant_id = MERCHANT_ID;
$merchant_secret = MERCHANT_SECRET;

session_start();

if(isset($_POST["sumbit_type"]) && $_POST["sumbit_type"]=="payment"){
    
$order_id = $checkout->getNextOrderId(); 
$_SESSION["new_order_id"] = $order_id ; 
$checkout->insertPayment(5,$order_id); //5  =>  pending payment 
$price = $_SESSION['cart_total']; 
$currency = "LKR";
$name = null;
$items = null; 
$temp = null; 

$hash = strtoupper(
    md5(
        $merchant_id .
        $order_id .
        number_format($price, 2, '.', '') .
        $currency .
        strtoupper(md5($merchant_secret))
    )
);

$obj = new stdClass();
$obj->order_id = $order_id;
$obj->merchant_id = $merchant_id;
$obj->name = $name;
$obj->price = $price;
$obj->currency = $currency;
$obj->hash = $hash;

echo json_encode($obj);

} 

// if(isset($_POST["sumbit_type"]) && $_POST["sumbit_type"]=="order"){

// }