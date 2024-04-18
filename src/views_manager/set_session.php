<?php
session_start(); // Make sure you have this at the top

if (isset($_POST['productId'])) {
    $_SESSION['selectedProductId'] = $_POST['productId'];
    echo "Session variable set for product ID: " . $_SESSION['selectedProductId'];
} else {
    echo "Product ID not received";
}
?>