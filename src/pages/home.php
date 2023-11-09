<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/home.css">
    <link href="https://fonts.cdnfonts.com/css/hero-new" rel="stylesheet" type="text/css">

</head>

<body>

    <div class="main-container">

        <?php
        // Initialize the session
        session_start();

        // Check if the user is logged in, show registered header if not then redirect show unregistered header
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            include '../components/unreg_header.php';
        } else {
            include '../components/reg_header.php';
        }
        include '../components/carousel.php';
        ?>

    </div>

    <div class="secondary-container">
        <div class="arrivals">
            <?php include '../components/new_arivals_slider.php' ?>
        </div>
<!-- 
        <div class="secondary-inner">
            <div class="grid-item-1">
                <div class="grid-inner-item-1">
                    <a href="build.php" class="build-btn">Build your PC</a>
                </div>
                <div class="grid-inner-item-2">

                </div>
            </div>
            <div class="grid-item-2">
                <h3>Trending Builds</h3>
            </div>
        </div> -->

        <div class="treasury-inner">
            <div class="grid2-item-1">
                <div class="grid2-inner-item-1">
                    <h3>News</h3>
                    <div class="news-content">
                        
                        <p>Winner of the Top-Notch website Award at TopWeb.LK</p>
                        <p>Winner of the Most Popular Award at BestWeb.lk</p>
                        <p>In case of faulty products, we have an upstanding warranty and claim procedures to make sure that your requirements are met in minimum time loss as possible</p>
                        <p>In case your requirements supersedes what the local market has to offer, we will provide you with assistance to meet these requirements.</p>
                        <p>To further facilitate your access to your needs, we offer to deliver to meet your requirements straight to where you live within Sri Lankan borders.</p>
                    </div>
                </div>
                <!-- <div class="grid2-inner-item-2">
                    <div class='slider-img-container'>
                            <img src='../../resources/images/map.png' alt='item img' class='img' />
                        </div>
                </div> -->
            </div>
            <div class="grid2-item-2">
                <h3>Trending Builds</h3>
                <div class="trending-builds-container">
                    <div class='items-trending'>
                        <div class='slider-img-container'>
                            <img src='../../resources/images/trending_builds/image1.png' alt='item img' class='img' />
                        </div>
                        <div class='info-container'>
                            <p>Nano-X Creator PRO V2 (AMD RYZEN™ 7000 SERIES)</p>
                            <p>Rs. 1,130,000</p>
                        </div>
                    </div>
                    <div class='items-trending'>
                        <div class='slider-img-container'>
                            <img src='../../resources/images/trending_builds/image2.png' alt='item img' class='img' />
                        </div>
                        <div class='info-container'>
                            <p>Nano-X Creator Lite (12th gen & DDR5)</p>
                            <p>Rs. 505,500</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../components/footer.php' ?>

</body>

</html>