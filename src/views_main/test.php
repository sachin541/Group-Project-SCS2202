<?php
require_once '../classes/database.php'; 
require_once '../classes/product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$category = isset($_POST['category']) ? $_POST['category'] : 'laptop'; // Default to 'laptop' if no POST request
$laptopProducts = $product->getProductsByCategory($category);

?>


<?php require_once '../components/headers/main_header.php';?> 

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products</title>
<link rel="stylesheet" type="text/css" href="../../resources/css/product_listnew.css" />
<!-- <link rel="stylesheet" type="text/css" href="../../resources/css/sidenav.css" /> -->
</head>
<body>







<div class="products-container">
    <?php foreach ($laptopProducts as $item): ?>
    <div class="product-card">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image1']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
        <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
        <p><?php echo htmlspecialchars($item['product_description']); ?></p>
        <p>Price: $<?php echo htmlspecialchars($item['price']); ?></p>
        <p>Discount: $<?php echo htmlspecialchars($item['discount']); ?>%</p> <!-- Assuming discount is a percentage -->
        <p>Brand: <?php echo htmlspecialchars($item['brand']); ?></p>
        <!-- Add to Cart Button -->
        <form action="../helpers/build_create.php" method="post">
            <input type="hidden" name="handler_type" value="set_item">
            <input type="hidden" name="category" value="<?php echo $category ?>">
            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
            <input type="submit" value="Add to Build" class="add-to-cart-button">
        </form>
    </div>
    <?php endforeach; ?>
</div>

</body>
</html>