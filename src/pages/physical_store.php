<?php
// Initialize the session
session_start();
$staff_id = "";
// Check if the user is already logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "staff") {
    header("location: login.php");
    exit;
} else {
    $staff_id = $_SESSION["id"];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Physical store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/store.css" type="text/css">
</head>

<body>
    <?php include '../components/reg_header.php'
    ?>

    <div class="store-outer-container">
        <div class="store-inner-1">
            <div>
                <h2 style="color:gray">WELCOME ...</h2>
                <h1>TO COMPUTIFY !</h1>
            </div>
            <div class="button-box">
                <a><button id="new-invo"><img src="../../resources/images/bill.png" alt="Next" height="18px" width="auto" style="margin-right: 1rem;" />New Bill</button></a>
                <a href=""><button><img src="../../resources/images/quotation.png" alt="Next" height="18px" width="auto" style="margin-right: 1rem;" />Quotations</button></a>
                <a href="./stock.php"><button><img src="../../resources/images/stock.png" alt="Next" height="18px" width="auto" style="margin-right: 1rem;" />Stocks</button></a>
                <a href=""><button><img src="../../resources/images/history.png" alt="Next" height="18px" width="auto" style="margin-right: 1rem;" />Bill History</button></a>
            </div>
            <div class="msg-box">
                <h3>Customer Messages</h3>
            </div>
        </div>
        <div class="store-inner-2">
            <div class="new-stock-arrivals">
                <h3>New Stock Arrivals</h3>
            </div>
            <div class="staff-member-box">
                <h3>Active Members</h3>
            </div>
            <div class="deliveries-box">
                <h3>Deliveries</h3>
            </div>
        </div>
    </div>

    <?php
    include '../components/footer.php';
    include '../components/bill.php';
    ?>
    <script src="../../resources/js/bill.js"></script>
</body>

</html>