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
<title>Laptop Products</title>
<link rel="stylesheet" type="text/css" href="../../resources/css/product_listnew.css" />
<!-- <link rel="stylesheet" type="text/css" href="../../resources/css/sidenav.css" /> -->
</head>
<body>


<aside class="main-side-nav">
  <nav class="nav-panel">
    <ul class="nav-list">

    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="laptop">
          <input type="submit" value="     LAPTOPS     " class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="CPU">
          <input type="submit" value="CPU" class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="gpu">
          <input type="submit" value="GPU" class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="memory">
          <input type="submit" value="Memory" class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="motherboard">
          <input type="submit" value="Motherboard" class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="powersupply">
          <input type="submit" value="PowerSupply" class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="storage">
          <input type="submit" value="Storage" class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="CPU">
          <input type="submit" value="CPU" class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="gpu">
          <input type="submit" value="GPU" class="nav-link">
        </form>
    </li>
    <!-- <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="CPU_cooler">
          <input type="submit" value="CPU_Cooler" class="nav-link">
        </form>
    </li> -->
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="case">
          <input type="submit" value="Case" class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="monitor">
          <input type="submit" value="Monitor" class="nav-link">
        </form>
    </li>
    <li class="nav-item">
        <form action="product_list.php" method="post">
          <input type="hidden" name="category" value="accessories">
          <input type="submit" value="Accessories" class="nav-link">
        </form>
    </li>


     
      
    </ul>
  </nav>
</aside>




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
        <form action="product_details.php" method="get">
            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
            <input type="submit" value="Add to Cart" class="add-to-cart-button">
        </form>
    </div>
    <?php endforeach; ?>
</div>

</body>
</html>

