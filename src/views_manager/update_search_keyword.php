<?php
session_start(); // Start or resume a session

// Check if the product ID is provided
if (isset($_GET['productID'])) {
    // Set the product ID in the session
    $_SESSION['selectedProductID'] = $_GET['productID'];
    
    echo "Session variable set to " . $_SESSION['selectedProductID'];
} else {
    echo "Product ID not provided";
}
?>

