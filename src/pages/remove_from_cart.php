<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "customer") {
    header("location: login.php");
    exit;
} else {
    $customer_id = $_SESSION["id"];
}

// Check if product_id is set
if (isset($_GET["product_id"]) && !empty($_GET["product_id"])) {
    $product_id = $_GET["product_id"];

    include_once '../utils/dbConnect.php';
    $conn = OpenCon();

    $sql = "DELETE FROM cart_items WHERE product_id = ? AND customer_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $product_id, $customer_id);

        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to cart page
            header("location: cart.php");
        } else {
            echo "Error removing item from cart.";
        }
    }

    CloseCon($conn);
} else {
    header("location: cart.php");
}
?>
