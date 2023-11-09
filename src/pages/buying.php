<?php
// Initialize the session
session_start();
$customer_id = "";
// Check if the user is already logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "customer") {
    header("location: login.php");
    exit;
} else {
    $customer_id = $_SESSION["id"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Purchases</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../resources/css/repairs_purchase.css">
</head>

<body>
    <!-- header -->
    <?php include '../components/reg_header.php'
    ?>

    <!-- body content -->
    <div class="repair-outer-container">
        <div class="repair-header-container">
            <img class="repair-img" src="../../resources/images/purchase.png" alt="purchase icon" />
            <span class="repair-header">Purchases</span>
        </div>
        <div class="repair-body-container">
            <div class="repair-grid-container1">
                <div class="repair-request-box">
                    <h3>Customer Details</h3>
                </div>
            </div>
            <div class="repair-grid-container2">
                <div class="current-repairs-box">
                    <h3>Coupens and Promotions</h3>
                </div>
                <div class="complains-box">
                    <h3>Purchase Pricing Box</h3>
                </div>
            </div>
        </div>
        <div class="purchase-btn-container">
            <button class="add-btn"><a href="###">Reject</a></button>
            <button class="remove-btn"><a href="###">Accept</a></button>
        </div>
    </div>

    <!-- footer -->
    <?php include '../components/footer.php' ?>

</body>

</html>