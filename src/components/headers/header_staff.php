<!-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../resources/css/main.css">
    <link rel="stylesheet" type="text/css" href="../../resources/css/headers.css">


</head>

<body>
    <header class="outer-grid-container">

        <div class="logo-container">
            <a href="../views_staff/staff_home.php"><img src="../../resources/images/logo2.png" alt="logo png" id="logo"
                    height="50px" /></a>
            <p class="name">COMPUTIFY</p>
        </div>


        <div class="container">
            <div id="menu" class="menu">

            </div>
            <div class="content">


                <a href="../views_staff/staff_home.php" class="topnav-item">Home</a> -->
                <!-- <a href="../views_staff/dashboard.php" class="topnav-item">Dashboard</a>
                <a href="../views_staff/product_list.php" class="topnav-item">Products</a>
                <a href="../views_staff/add_product.php" class="topnav-item">Add Products</a>
                <a href="../views_staff/InStoreOrder.php" class="topnav-item">Create Order</a>
                <a href="../views_staff/OrdersDeliverySub.php" class="topnav-item">Orders</a>

                <a href="../ultils/logout.php" class="unreg-log">Log Out</a> -->

               




                <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
            
        
    </style>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/header.css">
</head>
<body>
    <header class="outer-grid-container">
        <div class="logo-container">
            <a href="../views_staff/staff_home.php">
                <img src="../../resources/images/logo2.png" alt="logo png" id="logo" height="50px" />
            </a>
            <p class="name">COMPUTIFY</p>
        </div>
        <div class="hamburger" onclick="toggleMenu()">MAIN MENU</div>
        <div class="content" id="navLinks">

            <a href="../views_staff/product_list.php" class="topnav-item">
                <img src="../../resources/images/icons/product-M.png" alt="product_list" class="nav-icon">Products</a>

            <a href="../views_staff/add_product.php" class="topnav-item">
                <img src="../../resources/images/icons/add-product.png" alt="add_product" class="nav-icon">Add Product</a>

            <a href="../views_staff/InStoreOrder.php" class="topnav-item">
                <img src="../../resources/images/icons/create-order.png" alt="InStore" class="nav-icon">Create Order</a>

            <a href="../views_staff/OrdersDeliverySub.php" class="topnav-item">
                <img src="../../resources/images/icons/order-history.png" alt="InStore" class="nav-icon">Orders</a>

            <a href="../ultils/logout.php" class="unreg-log">
                <img src="../../resources/images/icons/logout.png" alt="Logout" class="nav-icon">Logout</a>
        </div>
    </header>
    <script src="header.js"></script>
</body>
</html>

<script>

function toggleMenu() {
    var links = document.getElementById("navLinks");
    if (links.style.display === "none") {
        links.style.display = "flex";
    } else {
        links.style.display = "none";
    }
}

</script>