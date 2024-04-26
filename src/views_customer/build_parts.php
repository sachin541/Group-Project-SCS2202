<?php
require_once '../classes/database.php'; 
require_once '../classes/product.php';
require_once '../components/headers/main_header.php';
if(!isset($_SESSION['role'])){
    header('Location: ../views_main/denied.php');
    exit;
}

$database = new Database();

$db = $database->getConnection();

$product = new Product($db);

$category = isset($_POST['category']) ? $_POST['category'] : 'CPU'; 

$laptopProducts = $product->getProductsByCategory($category);


function formatPrice($price) {
  return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}


$sidebarItems = [
  'CPU' => ['name' => 'CPU', 'optional' => false],
  'GPU' => ['name' => 'GPU', 'optional' => false],
  'Memory' => ['name' => 'Memory', 'optional' => false],
  'MotherBoard' => ['name' => 'MotherBoard', 'optional' => false],
  'PowerSupply' => ['name' => 'PowerSupply', 'optional' => false],
  'Storage' => ['name' => 'Storage', 'optional' => false],
  'Case' => ['name' => 'Case', 'optional' => false],
  'CPU Coolers' => ['name' => 'CPU Coolers', 'optional' => false],
  'Monitor' => ['name' => 'Monitor', 'optional' => true],
  'Mouse' => ['name' => 'Mouse', 'optional' => true],
  'Keyboard' => ['name' => 'Keyboard', 'optional' => true]
];

?>




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

  <div class="main-side-nav">
      <nav class="nav-panel">
          <ul class="nav-list">
              <?php foreach ($sidebarItems as $key => $item): ?>
                  <li class="nav-item">
                      <form action="build_parts.php" method="post">
                          <input type="hidden" name="category" value="<?php echo $key; ?>">
                          <input type="submit" value="<?php echo $item['name'] . ($item['optional'] ? ' (Optional)' : ''); ?>" class="nav-link<?php echo $item['optional'] ? ' optional' : ''; ?>">
                      </form>
                  </li>
              <?php endforeach; ?>
          </ul>
      </nav>
  </div>

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
              </div>
              <div class="product-actions">
                    <form action="../helpers/build_create.php" method="post">
                        <input type="hidden" name="handler_type" value="set_item">
                        <input type="hidden" name="category" value="<?php echo $category ?>">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <input type="submit" value="Add to Build" class="add-to-cart-button">
                    </form>
                    </div>
          </div>
          <?php endforeach; ?>

        
        
    </div>
    

  
</div>


</body>
</html>