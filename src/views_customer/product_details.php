<?php
require_once '../classes/database.php';
require_once '../classes/product.php';

// Check if the product ID is set in the query string
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    // Fetch the product details
    $productDetails = $product->getProductById($productId);
} else {
    // Redirect to another page if the product ID isn't provided
    header('Location: error_page.php');
    exit;
}

function formatPrice($price)
{
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>


<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" href="/resources/css/css_customer/product_detailsnew.css">

<div class="main-container">

    <div class="image-container">
        <?php if ($productDetails): ?>

            <!-- Image Carousel Container -->
            <div class="product-image-carousel">
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <?php if ($productDetails['image' . $i]): ?>
                        <img class="carousel-image"
                            src="data:image/jpeg;base64,<?php echo base64_encode($productDetails['image' . $i]); ?>"
                            alt="Product Image <?php echo $i; ?>" style="<?php echo $i === 1 ? '' : 'display: none;'; ?>">
                    <?php endif; ?>
                <?php endfor; ?>
                <button class="carousel-button prev" onclick="changeImage(-1)">❮</button>
                <button class="carousel-button next" onclick="changeImage(1)">❯</button>
            </div>
        </div>



        <div class="product-info">
            <h1 class="product-title"><?php echo htmlspecialchars($productDetails['product_name']); ?></h1>
            <p class="product-description"><?php echo htmlspecialchars($productDetails['product_description']); ?></p>
            <p class="product-price">Price: <?php echo htmlspecialchars(formatPrice($productDetails['price'])); ?></p>
            <p class="product-stock">In Stock: <?php echo htmlspecialchars($productDetails['quantity']); ?></p>
            <p class="product-brand">Brand: <?php echo htmlspecialchars($productDetails['brand']); ?></p>
            <!-- Add to Cart Form -->
            <form action="../helpers/cart_handler.php" method="post" class="add-to-cart-form">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="product_id" value="<?php echo $productDetails['id']; ?>">
                <input type="submit" value="Add to Cart" class="add-to-cart-button">
            </form>
        </div>



    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>


</div>

<!-- scripts -->
<script src="/resources/js/js_customer/product_details.js"></script>

<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>


<!-- this script is copied to product_details.js -->
<!-- <script>
let currentImageIndex = 0;
const images = document.querySelectorAll('.carousel-image');
let cycleCount = 0; // Variable to keep track of cycles
const totalCycles = images.length; // Total number of images
let interval; // Variable to store the interval

function changeImage(direction) {
    // Hide the current image
    images[currentImageIndex].style.display = 'none';
    
    // Change image index
    currentImageIndex += direction;
    
    // If we're at the last image, increase the cycle count
    if (currentImageIndex >= images.length) {
        currentImageIndex = 0;
        cycleCount++;
    } else if (currentImageIndex < 0) {
        currentImageIndex = images.length - 1;
    }
    
    // Show the new image
    images[currentImageIndex].style.display = 'block';

    // Stop cycling after one complete round
    if (cycleCount >= totalCycles) {
        clearInterval(interval);
    }
}

// Start automatic cycling
interval = setInterval(function() {
    changeImage(1);
}, 8000); // Change image every 8000 milliseconds (8 seconds)

</script> -->