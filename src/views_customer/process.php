<?php

require_once '../../config.php';

$merchant_id = MERCHANT_ID;
$merchant_secret = MERCHANT_SECRET;

session_start();
$order_id = "1234";

$name = $_POST["name"];
$price = $_POST["price"];

$price = $_SESSION['cart_total']; 

$currency = "LKR";

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