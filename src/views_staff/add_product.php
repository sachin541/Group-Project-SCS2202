<?php
require_once '../classes/database.php';
require_once '../classes/product.php';



$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// Fetch categories
$categories = $product->getAllCategories();

?>


<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/add_productnew.css">
<!-- <link rel="stylesheet" type="text/css" href="../../resources/css/add_emp.css"> -->


<?php

if (isset($_SESSION['product_adder'])) {
    $product_adder = htmlspecialchars($_SESSION['product_adder']);
    unset($_SESSION['product_adder']); // Clear the message after displaying
} ?>



<form action="../helpers/product_handler.php" method="post" enctype="multipart/form-data">
    <?php if (!empty($product_adder)): ?>
        <div style="color: Blue;" class="alert alert-danger"><?= $product_adder ?></div>
    <?php endif; ?>
    <div>
        <input type="text" name="product_name" placeholder="Product Name" required>
    </div>
    <div>
        <select name="category" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['category']) ?>">
                    <?= htmlspecialchars($category['category']) ?>
                </option>
            <?php endforeach; ?>
        </select>
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
    <!-- <div>
        <input type="text" name="discount" placeholder="Discount">
    </div> -->
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


<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>