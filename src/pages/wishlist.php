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
    <title>Wish list</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../resources/css/cart.css">
</head>

<body>
    <?php include '../components/reg_header.php' ?>
    <div class="outer-container">
        <div class="header-container">
            <img class="img" src="../../resources/images/heart.png" alt="cart icon" />
            <span class="header">Wish List</span>
        </div>
        <div class="body-container">
            <div class="cart-body">
                <ol class="list">
                    <?php
                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    // Prepare an retrieve statement
                    $sql = "SELECT p.id as product_id, p.description, p.image1 FROM product AS p JOIN wishlist_items AS w ON p.id = w.product_id WHERE w.customer_id = $customer_id";

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
                                    <a href='' class='add-btn'>To Cart</a>
                                    <a href='remove_from_wishlist.php?product_id=" . $row['product_id'] . "' class='remove-btn'>Drop</a>
                                </div>
                            </li>";
                            }
                        }
                        CloseCon($conn);
                    }
                    ?>
                </ol>
            </div>
        </div>
    </div>
    <?php include '../components/footer.php' ?>
</body>

</html>