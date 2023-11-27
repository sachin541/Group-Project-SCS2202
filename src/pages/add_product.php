<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product</title>
<link rel="stylesheet" type="text/css" href="../../resources/css/add_productnew.css" />
<!-- <link rel="stylesheet" type="text/css" href="../../resources/css/add_emp.css" /> -->

</head>

<body>

<?php require_once '../components/headers/main_header.php';?>

<?php
    
    if (isset($_SESSION['product_adder'])) {
        $product_adder = htmlspecialchars($_SESSION['product_adder']);
        unset($_SESSION['product_adder']); // Clear the message after displaying
    }?>

    
    
<form action="../helpers/product_handler.php" method="post" enctype="multipart/form-data">
    <?php
            if (!empty($product_adder)) {
                echo '<div style="color: Blue; class="alert alert-danger">' . $product_adder . '</div>';
                }?>  
    <div>
        <input type="text" name="product_name" placeholder="Product Name" required>
    </div>
    <div>
        <input type="text" name="category" placeholder="Category" required>
    </div>
    <div>
        <input type="number" name="quantity" placeholder="Quantity" required>
    </div>
    <div>
        <textarea name="product_description" placeholder="Description" required></textarea>
    </div>
    <div>
        <input type="text" name="price" placeholder="Price" required>
    </div>
    <div>
        <input type="text" name="discount" placeholder="Discount">
    </div>
    <div>
        <input type="text" name="brand" placeholder="Brand">
    </div>
    <div>
        <input type="file" name="image1" placeholder="Image 1">
    </div>
    <div>
        <input type="file" name="image2" placeholder="Image 2">
    </div>
    <div>
        <input type="file" name="image3" placeholder="Image 3">
    </div>

    <input type="hidden" name="formType" value="addProduct">  
    <!-- only trigger the first post block in handler -->
    <div>
        <input type="submit" value="Add Product">
    </div>
    
</form>

</body>
</html>

