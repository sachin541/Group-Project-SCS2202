<?php
require_once '../classes/database.php';
require_once '../classes/product.php';

$database = new Database();

$db = $database->getConnection();

$product = new Product($db);

$category = isset($_POST['category']) ? $_POST['category'] : 'CPU'; // Default to 'laptop' if no POST request
$laptopProducts = $product->getProductsByCategory($category);



function formatPrice($price)
{
  return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>

<!-- Template Top -->
<?php require_once '../templates/main_top.php'; ?>

<!-- Stylesheets -->
<link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/product_listnew.css" />
<!-- <link rel="stylesheet" type="text/css" href="../../resources/css/sidenav.css" /> -->

</head>

<body>

  <!-- Header -->
  <?php require_once '../templates/main_header.php'; ?>

  <div class="main-container">

    <aside class="main-side-nav">
      <nav class="nav-panel">
        <ul class="nav-list">


          <li class="nav-item">
            <form action="build_parts.php" method="post">
              <input type="hidden" name="category" value="CPU">
              <input type="submit" value="CPU" class="nav-link">
            </form>
          </li>
          <li class="nav-item">
            <form action="build_parts.php" method="post">
              <input type="hidden" name="category" value="GPU">
              <input type="submit" value="GPU" class="nav-link">
            </form>
          </li>
          <li class="nav-item">
            <form action="build_parts.php" method="post">
              <input type="hidden" name="category" value="Memory">
              <input type="submit" value="Memory" class="nav-link">
            </form>
          </li>
          <li class="nav-item">
            <form action="build_parts.php" method="post">
              <input type="hidden" name="category" value="MotherBoard">
              <input type="submit" value="Motherboard" class="nav-link">
            </form>
          </li>
          <li class="nav-item">
            <form action="build_parts.php" method="post">
              <input type="hidden" name="category" value="PowerSupply">
              <input type="submit" value="PowerSupply" class="nav-link">
            </form>
          </li>
          <li class="nav-item">
            <form action="build_parts.php" method="post">
              <input type="hidden" name="category" value="Storage">
              <input type="submit" value="Storage" class="nav-link">
            </form>
          </li>

          <li class="nav-item">
            <form action="build_parts.php" method="post">
              <input type="hidden" name="category" value="Case">
              <input type="submit" value="Case" class="nav-link">
            </form>
          </li>
          <!-- <li class="nav-item">
          <form action="build_parts.php" method="post">
            <input type="hidden" name="category" value="monitor">
            <input type="submit" value="Monitor" class="nav-link">
          </form>
      </li>
      <li class="nav-item">
          <form action="build_parts.php" method="post">
            <input type="hidden" name="category" value="accessories">
            <input type="submit" value="Accessories" class="nav-link">
          </form>
      </li> -->




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
            <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image1']); ?>"
              alt="<?php echo htmlspecialchars($item['product_name']); ?>">
          </div>
          <div class="product-details">
            <h3 class="product-title">
              <?php echo htmlspecialchars($item['product_name']); ?>
            </h3>
            <p class="product-price">Price: Rs
              <?php echo htmlspecialchars(number_format($item['price'])); ?>
            </p>
            <p class="product-brand">Brand:
              <?php echo htmlspecialchars($item['brand']); ?>
            </p>
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


  <!-- Footer -->
  <?php require_once '../templates/main_footer.php'; ?>

  <!-- Template Bottom -->
  <?php require_once '../templates/main_bottom.php'; ?>