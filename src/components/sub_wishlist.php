<?php
session_start();
include_once '../utils/dbConnect.php';

$conn = OpenCon();
$productID = $_POST['productID'];
$customer_id = $_SESSION["id"];

$wishlist_count = "SELECT count(id) AS wishlist_count FROM wishlist_items WHERE customer_id = $customer_id AND product_id = $productID";

if ($result = mysqli_query($conn, $wishlist_count)) {
    $row = mysqli_fetch_array($result);
    if (0) {
        echo "This product has been already added to your wishlist";
    } else {
        $sql = "INSERT INTO wishlist_items (customer_id, product_id) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_customer_id, $param_product_id);

            $param_customer_id = $customer_id;
            $param_product_id = $productID;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "1";
            } else {
                echo "0";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
