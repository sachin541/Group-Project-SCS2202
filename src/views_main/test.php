<?php require_once '../components/headers/main_header.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page Layout</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/test.css">
    <link rel="stylesheet" type="text/css" href="../../resources/css/homeProductCard.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">   
</head>
<body>

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
            <!-- <img src="../../resources/images/newhomepage/brands/1.jpg" alt="brand"> -->
            <img src="../../resources/images/newhomepage/brands/2.jpg" alt="brand">
            <img src="../../resources/images/newhomepage/brands/3.jpg" alt="brand">
            <img src="../../resources/images/newhomepage/brands/4.jpg" alt="brand">
            <img src="../../resources/images/newhomepage/brands/5.jpg" alt="brand">
            <img src="../../resources/images/newhomepage/brands/6.jpg" alt="brand">
            
            <!-- Add more images as needed -->
        </div>  
    </div>

    <!-- Row with Large Box -->
    <div class="row-products" style="height: 60vh; background-color: white; position: relative;">
        <div class="box large-box-items" style="background-color: black;">
            
            <div class="products-scroll-container"></div>
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
                <img src="../../resources/images/newhomepage/builds.png" alt="Custom PC Builds" style="width:50%; height:auto;">
                <p>Custom PC Builds</p>
                
                <!-- Button linking to a different page -->
                <a href="path/to/your/page" class="service-cta">View More</a>
            </div>
        </div>

        <div class="box small-box" style="background-color: white;">
            <div class="service service-white" style="background-color: white;">
                
                <img src="../../resources/images/newhomepage/repairs.png" alt="Custom PC Builds" style="width:50%; height:auto;">
                <p>PC Repairs</p>
                
                <!-- Button linking to a different page -->
                <a href="path/to/your/page" class="service-cta">View More</a>
            </div>
        </div>
    </div>

   
    <div class="row" style="height: 50vh;">

        <div class="box small-box" style="background-color: white;">
            <div class="service service-white" style="background-color: white;">
                
                <img src="../../resources/images/newhomepage/delivery.png" alt="Custom PC Builds" style="width:50%; height:auto;">
                <p>Home Delivery</p>
                
                <!-- Button linking to a different page -->
                <a href="path/to/your/page" class="service-cta">View More</a>
            </div>
        </div>

        <div class="box small-box" style="background-color: black;">
            <div class="service">
                <!-- Make image smaller by adjusting the style or through CSS class -->
                <img src="../../resources/images/newhomepage/products.png" alt="Custom PC Builds" style="width:50%; height:auto;">
                <p>Newest Products</p>
                
                <!-- Button linking to a different page -->
                <a href="path/to/your/page" class="service-cta">View More</a>
            </div>
        </div>

        
    </div>
    
    <!-- More rows can be added as needed, adjusting the inline styles for height and background color -->
</div>

</body>
</html>



<script>
document.addEventListener("DOMContentLoaded", function() {
    const productsContainer = document.querySelector('.products-scroll-container');

    for (let i = 1; i <= 10; i++) {
        const productCard = document.createElement('div');
        productCard.classList.add('product-card');

        productCard.innerHTML = `
            <img src="../../resources/images/newhomepage/6.jpg" alt="Product ${i}" class="product-image">
            <div class="product-info">
                <h3 class="product-title">Product Name ${i}</h3>
                <p class="product-description">Short description of product ${i} highlighting its key features.</p>
                <div class="product-price-rating">
                    <span class="product-price">$99.99</span>
                </div>
                <button class="btn-add-to-cart">View</button>
            </div>
        `;
        
        productsContainer.appendChild(productCard);
    }
});
</script>
