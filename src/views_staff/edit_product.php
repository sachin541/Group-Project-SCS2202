<?php
require_once '../classes/database.php';
require_once '../classes/product.php';
require_once '../components/headers/main_header.php';
$database = new Database();
$db = $database->getConnection();
$productobj = new Product($db);

$productId = $_GET['product_id'] ?? null;
$product = null;

if ($productId) {
    $product = $productobj->getProductById($productId);
}

if (!$product) {
    echo "Product not found";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/product_edit.css" />
</head>
<body>
    <form action="../helpers/edit_product.php" method="post" enctype="multipart/form-data" class="product-form">
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">

        <div class="form-group product-name-group">
            <label for="product_name" class="form-label product-name-label">Product Name:</label>
            <input type="text" id="product_name" name="product_name" class="form-input product-name-input" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
        </div>

        <div class="form-group category-group">
            <label for="category" class="form-label category-label">Category:</label>
            <input type="text" id="category" name="category" class="form-input category-input" value="<?php echo htmlspecialchars($product['category']); ?>" required>
        </div>

        <div class="form-group quantity-group">
            <label for="quantity" class="form-label quantity-label">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="form-input quantity-input" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
        </div>

        <div class="form-group description-group">
            <label for="product_description" class="form-label description-label">Product Description:</label>
            <textarea id="product_description" name="product_description" class="form-textarea description-textarea" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
        </div>

        <div class="form-group price-group">
            <label for="price" class="form-label price-label">Price:</label>
            <input type="text" id="price" name="price" class="form-input price-input" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>

        <div class="form-group discount-group">
            <label for="discount" class="form-label discount-label">Discount:</label>
            <input type="text" id="discount" name="discount" class="form-input discount-input" value="<?php echo htmlspecialchars($product['discount']); ?>">
        </div>

        <div class="form-group brand-group">
            <label for="brand" class="form-label brand-label">Brand:</label>
            <input type="text" id="brand" name="brand" class="form-input brand-input" value="<?php echo htmlspecialchars($product['brand']); ?>">
        </div>

        <div class="form-group image1-group">
            <label for="image1" class="form-label image1-label">Image 1:</label>
            <input type="file" id="image1" name="image1" class="form-file image1-file">
        </div>

        <div class="form-group image2-group">
            <label for="image2" class="form-label image2-label">Image 2:</label>
            <input type="file" id="image2" name="image2" class="form-file image2-file">
        </div>

        <div class="form-group image3-group">
            <label for="image3" class="form-label image3-label">Image 3:</label>
            <input type="file" id="image3" name="image3" class="form-file image3-file">
        </div>

        <div class="form-group submit-group">
            <input type="submit" value="Update Product" class="form-submit submit-button">
        </div>
    </form>
</body>
</html>

