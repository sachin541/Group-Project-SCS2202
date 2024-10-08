<?php
require_once '../classes/database.php'; 
require_once '../classes/product.php';
require_once '../components/headers/main_header.php';

if(!(isset($_SESSION['role'])) || !($_SESSION['role'] != 'manager' || $_SESSION['role'] != 'staff')){
  header('Location: ../views_main/denied.php');
  exit;
}
require_once '../components/confirm_modal.php'; 
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$categories = $product->getAllCategories();

$orderArray = ["Laptop", "CPU" , "GPU", "Memory", "MotherBoard", "CPU Coolers", "PowerSupply", "Storage", "Case", "Monitor", "Keyboard" , "Mouse", "Accessories"];

usort($categories, function ($a, $b) use ($orderArray) {
  $indexA = array_search($a['category'], $orderArray);
  $indexB = array_search($b['category'], $orderArray);

  return $indexA - $indexB;
});
// echo $_SESSION["category"]; 

$category = isset($_POST['category']) ? $_POST['category'] : 'laptop'; // Default to 'laptop' if no POST request

if(isset($_SESSION["category"])){
    $category = $_SESSION["category"]; 
    unset($_SESSION["category"]); 
}


$laptopProducts = $product->getProductsByCategory($category);

usort($laptopProducts, function($a, $b) {
  return $b['quantity'] <=> $a['quantity'];
});

function formatPrice($price) {
  return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products</title>
<link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/product_list_staff.css" />
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
                  <p class="product-qty">Stock: <?php echo htmlspecialchars($item['quantity']); ?></p>
              </div>
                <!-- stock control -->
              <div class="stock-controls">
                <form action="../helpers/product_handler.php" method="post" id="stock-form-<?php echo $item['id']; ?>">

                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="formType" value="update_qty">
                    <input type="hidden" name="category" value="<?php echo $category; ?>">

                    <button type="button" onclick="adjustStock(<?php echo $item['id']; ?>, -1)">-</button>
                    <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="0">
                    <button type="button" onclick="adjustStock(<?php echo $item['id']; ?>, 1)">+</button>
                    
                    <input type="submit" value="Update">
                </form>
              </div>
              <!-- edit product -->
              <div class="product-actions">
                  <form action="./edit_product.php" method="get">
                      <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                      <input type="hidden" name="formType" value="update_product">
                      <input type="submit" value="Edit" class="add-to-cart-button">
                  </form>
              </div>
                <!-- delete product -->
              <div class="product-actions">

                <form action="../helpers/product_handler.php" method="post" class="delete-form">
                  <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                  <input type="hidden" name="formType" value="delete_product">
                  <input type="hidden" name="category" value="<?php echo $category; ?>">
                  <input type="button" value="Delete" class="add-to-cart-button delete-btn" data-message="Are you sure you want to remove this item?">
                </form>


              </div>
                <!-- implement in future  -->
              <div class="product-actions"> 
                <form action="../helpers/InStoreHandler.php" method="post" class="add-to-cart-form">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="add_to_order" value="1">
                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                    <input type="submit" value="Add to Order" class="add-to-cart-button">
                </form>
              </div>

          </div>
          <?php endforeach; ?>

        
        
           </div>
    

    




</div>


</body>
</html>



<script>
function adjustStock(productId, adjustment) {
    var form = document.getElementById('stock-form-' + productId);
    var quantityInput = form.querySelector('input[name="quantity"]');
    var newQuantity = parseInt(quantityInput.value) + adjustment;
    quantityInput.value = Math.max(0, newQuantity); // Ensures stock is not negative
}

function confirmDelete() {
    return confirm('Are you sure you want to delete this product?');
}
</script>