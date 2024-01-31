<?php
require_once '../components/headers/main_header.php';
?>


<!DOCTYPE html>
<html>
<head>
    <title>Grid Layout Example</title>
    <link rel="stylesheet"  href="../../resources/css/css_tech/technician_home.css">
</head>
<div id="cont">
    <div class="grid-container">
        <a href="./acceptOrders.php" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/staff/product_center.png" class="foto" style="width:100%">
            <header>
                <h1>Orders</h1>
            </header>
        </div>
        </a>

        <a href="./add_product.php" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/staff/add_product.png" class="foto" style="width:100%">
            <header>
                <h1>Add Product</h1>
            </header>
        </div>
        </a>
        <a href="linkhere" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/technician/profile.png" class="foto" style="width:100%">
            <header>
                <h1>Profile</h1>
            </header>
        </div>
        </a> 
        
    </div>
</div>
</html>