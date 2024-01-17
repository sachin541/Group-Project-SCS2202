<?php

require_once '../classes/product.php';
require_once '../classes/database.php';
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$items = ["CPU", "GPU", "MotherBoard", "Memory", "Storage", "PowerSupply", "Case"];
$totalPrice = 0;
function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
  }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Create New Build</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/create_build.css">
</head>
<body>

<div class="main-container build-page">

    <div class="selected-components components-section">
        <h2 class="components-heading">Selected Components</h2>
        <div class="components-list">
            <?php 
            foreach ($items as $item) {
                if (isset($_SESSION[$item])) {
                    $productId = $_SESSION[$item];
                    $productDetails = $product->getProductById($productId);
                    if ($productDetails) {
                        $totalPrice += $productDetails['price']; // Add product price to total
                        ?>
                        <div class="component-item">
                            <?php if ($productDetails['image1']) { ?>
                                <img class="component-image" src="data:image/jpeg;base64,<?= base64_encode($productDetails['image1']) ?>" 
                                alt="<?= htmlspecialchars($productDetails['product_name']) ?>">
                            <?php } ?>
                            <div class="component-details">
                                <p class="component-name"><?= htmlspecialchars($productDetails['product_name']) ?></p>
                                <p class="component-price">Price: <?= htmlspecialchars(formatPrice($productDetails['price'])) ?></p>
                            </div>
                        </div>
                    <?php }
                }
            }
            ?>
        </div>
    </div>

    <div class="additional-info info-section">
        <h1 class="info-heading">Create New Build Request</h1>
       
        <form action="../helpers/build_create.php" method="post" class="build-form">
            <div class="form-group">
                <label for="customer_name" class="form-label">Your Name:</label>
                <input type="text" id="customer_name" name="customer_name" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="contact_number" class="form-label">Contact Number:</label>
                <input type="tel" id="contact_number" name="contact_number" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="additional_notes" class="form-label">Additional Notes:</label>
                <textarea id="additional_notes" name="additional_notes" class="form-textarea"></textarea>
            </div>

            <div class="total-price">
                <p class="total-label">Total Price: <span class="price"><?= htmlspecialchars(formatPrice($totalPrice)) ?></span></p>
            </div>  
            <!-- hidden fields -->
            <input type="hidden" name="handler_type" value="create_new_build">
            <!-- :p change this later  -->
            <input type="hidden" name="build_total" value="<?php echo $totalPrice; ?>"> 


            <div class="form-actions">
                <input type="submit" value="Submit Build Request" class="submit-button">
            </div>
        </form>
    </div>

</div>

</body>
</html>


