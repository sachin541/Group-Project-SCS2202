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
<style>
    .checkout-container {
    text-align: center;
    padding: 20px;
}

.checkout-btn {
    padding: 10px 20px;
    background-color: green;
    color: white;
    text-decoration: none;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.checkout-btn:hover {
    background-color: #45a049;
}

</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../resources/css/cart.css">
</head>

<body>
    <?php include '../components/reg_header.php' ?>
    <div class="outer-container">
        <div class="header-container">
            <img class="img" src="../../resources/images/cart.png" alt="cart icon" />
            <span class="header">Your Cart</span>
        </div>
        <div class="body-container">
            <div class="cart-body">
                <ol class="list">
                    <?php
                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    // Prepare an retrieve statement
                    $sql = "SELECT p.id as product_id, p.description, p.image1 FROM product AS p JOIN cart_items AS c ON p.id = c.product_id WHERE c.customer_id = $customer_id";

                    if ($result = mysqli_query($conn, $sql)) {

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<li class='item'>
                                        <div class='img-container'>
                                            <img class='item-img' src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                        </div>
                                        <div class='description'>
                                            <p>" . $row['description'] . "</p>
                                        </div>
                                        <div class='grid-inner'>
                                            <a href='' class='add-btn'>Buy</a>
                                            <a href='remove_from_cart.php?product_id=" . $row['product_id'] . "' class='remove-btn'>Drop</a>
                                        </div>
                                    </li>";
                            }
                        }
                        CloseCon($conn);
                    }
                    ?>
                </ol>
            </div>
            <div class="checkout-container">
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
            </div>
        </div>
        <?php include '../components/footer.php' ?>
    </div>
</body>

</html>