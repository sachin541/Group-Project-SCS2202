<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Custom PC Builder</title>
    <!-- Add your CSS links here -->
</head>
<body>

<div class="components-container">
    <form action="products.php" method="get">
        <div class="component">
            <label>CPU</label>
            <button type="submit" name="component" value="CPU">Choose a CPU</button>
        </div>
        <div class="component">
            <label>Motherboard</label>
            <button type="submit" name="component" value="Motherboard">Choose a Motherboard</button>
        </div>
        <!-- Repeat for other components -->
    </form>
</div>

<div class="products-container">
    <!-- This section will be populated with products based on the selected component -->
    <?php 
    if (isset($_GET['component'])) {
        $selectedComponent = $_GET['component']; // This should match a session variable or a database query
        $laptopProducts = $_SESSION[$selectedComponent]; // Assuming you have session variables with arrays of products

        foreach ($laptopProducts as $item): ?>
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
        <?php endforeach; 
    }
    ?>
</div>

</body>
</html>
