<?php
require_once '../classes/database.php'; 
require_once '../classes/build.php'; // Change to the Build class
require_once '../classes/product.php'; 
require_once '../classes/order.php'; 
require_once '../components/headers/main_header.php';

if($_SESSION['role'] != 'technician'){
    header('Location: ../views_main/denied.php');
    exit; 
}

$technicianId = $_SESSION['user_id'];

$buildFilter = isset($_GET['build_filter']) ? $_GET['build_filter'] : 'active'; // Use build_filter

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$order = new Order($db);

function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}

print_r($order->test()); 
// echo date("Y-m-d" , strtotime("now")); 
?>