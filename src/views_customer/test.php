<?php
require_once "../classes/checkout.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

$database = new Database(); 
$db = $database->getConnection(); 
$checkout = new Checkout($db);

// $merchant_id         = $_POST['merchant_id'];
$order_id = $_POST['order_id'];
// $payhere_amount      = $_POST['payhere_amount'];
// $payhere_currency    = $_POST['payhere_currency'];
$status_code         = $_POST['status_code'];
// $md5sig              = $_POST['md5sig'];

$merchant_secret = 'XXXXXXXXXXXXX'; // Replace with your Merchant Secret

// $local_md5sig = strtoupper(
//     md5(
//         $merchant_id . 
//         $order_id . 
//         $payhere_amount . 
//         $payhere_currency . 
//         $status_code . 
//         strtoupper(md5($merchant_secret)) 
//     ) 
// );
$checkout->PayHereNotify($status_code,$order_id);

// if (($status_code == 2) ){
        
// }

?>