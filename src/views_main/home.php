<?php
require_once '../classes/product.php';
require_once '../classes/database.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// Fetch the latest 5 products
$latestProducts = $product->getLatestProducts(5);

function truncateText($text, $maxLength = 100)
{
    if (strlen($text) > $maxLength) {
        return substr($text, 0, $maxLength) . "...";
    } else {
        return $text;
    }
}

?>

<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" type="text/css" href="/resources/css/test.css">
<link rel="stylesheet" type="text/css" href="/resources/css/homeProductCard.css">


<div class="flex-container">
    <!-- Row with Large Box -->
    <div class="row" style="height: 75vh;">
        <div class="box large-box hero-box">
            <div class="hero-text">
                <h1 class="hero-title">Power Up Your Setup</h1>
                <p class="hero-subtitle">Explore the finest in PC hardware. Gear up for excellence.</p>
                <a href="../views_customer/product_list.php" class="hero-cta">Shop Now</a>

            </div>
        </div>
    </div>

    <div class="row" style="height: 18vh; background-color: black;">
        <div class="box large-box brands">
            <!-- <img src="/resources/images/newhomepage/brands/1.jpg" alt="brand"> -->
            <img src="/resources/images/newhomepage/brands/2.jpg" alt="brand">
            <img src="/resources/images/newhomepage/brands/3.jpg" alt="brand">
            <img src="/resources/images/newhomepage/brands/4.jpg" alt="brand">
            <img src="/resources/images/newhomepage/brands/5.jpg" alt="brand">
            <img src="/resources/images/newhomepage/brands/6.jpg" alt="brand">

            <!-- Add more images as needed -->
        </div>
    </div>

    <!-- Row with Large Box -->
    <div class="row-products" style="height: 60vh; background-color: white; position: relative;">
        <div class="box large-box-items" style="background-color: black;">

            <div class="products-scroll-container">
                <?php foreach ($latestProducts as $product): ?>
                    <div class="product-card">
                        <img src="data:image/jpeg;base64,<?= base64_encode($product['image1']) ?>"
                            alt="<?= htmlspecialchars($product['product_name']) ?>" class="product-image">
                        <div class="product-info">
                            <h3 class="product-title"><?= htmlspecialchars($product['product_name']) ?></h3>
                            <p class="product-description">
                                <?= htmlspecialchars(truncateText($product['product_description'], 80)) ?>
                            </p>
                            <!-- Adjusted -->
                            <div class="product-price-rating">
                                <span class="product-price">Rs <?= htmlspecialchars($product['price']) ?>/-</span>
                            </div>

                            <div class="product-actions">
                                <form action="../views_customer/product_details.php" method="get">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn-add-to-cart">View</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


        </div>
    </div>

    <div class="row" id="break" style="height: 30vh">
        <div id="services-box">
            <h2>Our Services</h2>
        </div>
    </div>


    <!-- Row with Small Boxes, each having a unique color -->
    <div class="row" style="height: 50vh;">
        <div class="box small-box" style="background-color: black;">
            <div class="service">
                <!-- Make image smaller by adjusting the style or through CSS class -->
                <img src="/resources/images/newhomepage/builds.png" alt="Custom PC Builds"
                    style="width:50%; height:auto;">
                <p>Custom PC Builds</p>

                <!-- Button linking to a different page -->
                <a href="path/to/your/page" class="service-cta">View More</a>
            </div>
        </div>

        <div class="box small-box" style="background-color: white;">
            <div class="service service-white" style="background-color: white;">

                <img src="/resources/images/newhomepage/repairs.png" alt="Custom PC Builds"
                    style="width:50%; height:auto;">
                <p>PC Repairs</p>

                <!-- Button linking to a different page -->
                <a href="path/to/your/page" class="service-cta">View More</a>
            </div>
        </div>
    </div>


    <div class="row" style="height: 50vh;">

        <div class="box small-box" style="background-color: white;">
            <div class="service service-white" style="background-color: white;">

                <img src="/resources/images/newhomepage/delivery.png" alt="Custom PC Builds"
                    style="width:50%; height:auto;">
                <p>Home Delivery</p>

                <!-- Button linking to a different page -->
                <a href="path/to/your/page" class="service-cta">View More</a>
            </div>
        </div>

        <div class="box small-box" style="background-color: black;">
            <div class="service">
                <!-- Make image smaller by adjusting the style or through CSS class -->
                <img src="/resources/images/newhomepage/products.png" alt="Custom PC Builds"
                    style="width:50%; height:auto;">
                <p>Newest Products</p>

                <!-- Button linking to a different page -->
                <a href="path/to/your/page" class="service-cta">View More</a>
            </div>
        </div>


    </div>

    <!-- More rows can be added as needed, adjusting the inline styles for height and background color -->
</div>

<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>