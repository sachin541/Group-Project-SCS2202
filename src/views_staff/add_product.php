<?php 
require_once '../components/headers/main_header.php';
if(!(isset($_SESSION['role'])) || !($_SESSION['role'] != 'manager' || $_SESSION['role'] != 'staff')){
    header('Location: ../views_main/denied.php');
    exit;
}

require_once '../classes/database.php'; 
require_once '../classes/product.php'; 
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    // Fetch categories
    $categories = $product->getAllCategories();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product</title>
<link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/add_productnew.css" />
<!-- <link rel="stylesheet" type="text/css" href="../../resources/css/css_manager/add_emp.css" /> -->
</head>

<body>



<?php
    if (isset($_SESSION['product_adder'])) {
        $product_adder = htmlspecialchars($_SESSION['product_adder']);
        unset($_SESSION['product_adder']); // Clear the message after displaying
    }
?>
<div class="form-con">
<form action="../helpers/product_handler.php" method="post" enctype="multipart/form-data">
    <h1>Add New Product</h1>
    <?php if (!empty($product_adder)): ?>
        <div style="color: white;" class="alert alert-danger"><?= $product_adder ?></div>
    <?php endif; ?>
    
    <div>
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" placeholder="Product Name" required>
    </div>
    <div>
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['category']) ?>"><?= htmlspecialchars($category['category']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" placeholder="Quantity" required>
    </div>
    <div>
        <label for="product_description">Description:</label>
    </div>

    <div>
        <textarea id="product_description" name="product_description" placeholder="Description" required></textarea>
    </div>
    <div>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" placeholder="Price" required>
    </div>
    <div>
        <label for="brand">Brand:</label>
        <input type="text" id="brand" name="brand" placeholder="Brand">
    </div>
    <div>
        <label for="image1">Image 1:</label>
        <input type="file" id="image1" name="image1" placeholder="Image 1">
    </div>
    <div>
        <label for="image2">Image 2:</label>
        <input type="file" id="image2" name="image2" placeholder="Image 2">
    </div>
    <div>
        <label for="image3">Image 3:</label>
        <input type="file" id="image3" name="image3" placeholder="Image 3">
    </div>

    <input type="hidden" name="formType" value="addProduct">
    <div>
        <input type="submit" value="Add Product">
    </div>
    
</form>
</div>
</body>
</html>


