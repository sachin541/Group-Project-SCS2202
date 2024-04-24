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
        <a href="./product_list.php" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/staff/product_center.png" class="foto" style="width:100%">
            <header>
                <h1>Products</h1>
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
        <a href="./InStoreOrder.php" class="card">
        <div class="card">
            <img src="../../resources/images/homePagImages/technician/profile.png" class="foto" style="width:100%">
            <header>
                <h1>Order</h1>
            </header>
        </div>
        </a> 
        
    </div>
</div>
</html>