<?php
require_once '../classes/database.php'; 
require_once '../classes/product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$categories = $product->getDistincCategoriesFromProduct();

// print_r($categories);

$orderArray = ["Laptop", "CPU" , "GPU", "Memory", "MotherBoard", "PowerSupply", "Storage", "Case", "Accessories"];

// Sort the $categories array based on the order defined in $orderArray
usort($categories, function ($a, $b) use ($orderArray) {
    $indexA = array_search($a['category'], $orderArray);
    $indexB = array_search($b['category'], $orderArray);

    return $indexA - $indexB;
});

// print_r($categories);

$category = isset($_POST['category']) ? $_POST['category'] : 'Laptop'; // Default to 'laptop' if no POST request
$laptopProducts = $product->getProductsByCategory($category);

// foreach ($categories as $itemC) {
//   echo htmlspecialchars($itemC['category']) . "<br>";
// }

function formatPrice($price) {
  return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}

//sort based on quantity 
usort($laptopProducts, function($a, $b) {
  return $b['quantity'] <=> $a['quantity'];
});


?>




<?php require_once '../components/headers/main_header.php';?> 

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products</title>
<link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/product_listnew.css" />
<!-- <link rel="stylesheet" type="text/css" href="../../resources/css/sidenav.css" /> -->
</head>
<body>

<div class="main-container">

<aside class="main-side-nav">
    <nav class="nav-panel">
        <ul class="nav-list">
            <?php foreach ($categories as $cat): ?>
            <li class="nav-item <?php if (strtolower($cat['category']) == strtolower($category)) echo 'selected-category'; ?>">
                <form action="product_list.php" method="post">
                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($cat['category']); ?>">
                    <input type="submit" value="<?php echo htmlspecialchars($cat['category']); ?>" class="nav-link <?php if (strtolower($cat['category']) == strtolower($category)) echo 'selected-category'; ?>">
                </form>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</aside>





    <div class="products-container">
        

        <!-- out of stock  -->
        <?php foreach ($laptopProducts as $item): ?>
        <div class="product-card <?php echo $item['quantity'] <= 0 ? 'product-out-of-stock' : ''; ?>">
            <?php if ($item['quantity'] <= 0): ?>
                <div class="out-of-stock-ribbon">Out of Stock</div>
            <?php endif; ?>

              <div class="product-image">
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image1']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
              </div>
              <div class="product-details">
                  <h3 class="product-title"><?php echo htmlspecialchars($item['product_name']); ?></h3>
                  <p class="product-price">Price: Rs <?php echo htmlspecialchars(number_format($item['price'])); ?></p>
                  <p class="product-brand">Brand: <?php echo htmlspecialchars($item['brand']); ?></p>
                  <p class="product-stock">In Stock: <?php echo htmlspecialchars($item['quantity']); ?></p>
              </div>
              <div class="product-actions">
                  <form action="product_details.php" method="get">
                      <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                      <input type="submit" value="Add to Cart" class="add-to-cart-button">
                  </form>
              </div>
          </div>
          <?php endforeach; ?>

        
        
          </div>
    

    




</div>


</body>
</html>

