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
            <a href="../views_main/home.php">
                <img src="../../resources/images/logo2.png" alt="logo png" id="logo" height="50px" />
            </a>
            <p class="name">COMPUTIFY</p>
        </div>
        <div class="hamburger" onclick="toggleMenu()">MAIN MENU</div>
        <div class="content" id="navLinks">
            <a href="../views_customer/product_list.php" class="topnav-item">
                <img src="../../resources/images/icons/bag.png" alt="Products" class="nav-icon">Products</a>
            <a href="../views_customer/view_cart.php" class="topnav-item">
                <img src="../../resources/images/icons/cart.png" alt="Cart" class="nav-icon">Cart</a>
            <a href="../views_customer/repairs.php" class="topnav-item">
                <img src="../../resources/images/icons/tools.png" alt="Repairs" class="nav-icon">Repairs</a>
            <a href="../views_customer/build_Item_selector.php" class="topnav-item">
                <img src="../../resources/images/icons/pc.png" alt="Builds" class="nav-icon">Builds</a>
            <a href="../views_customer/OrderList.php" class="topnav-item">
                <img src="../../resources/images/icons/order.png" alt="Orders" class="nav-icon">Orders</a>
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
