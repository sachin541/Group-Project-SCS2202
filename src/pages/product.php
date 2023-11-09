<?php
if ($_GET) {
    $productId = $_GET['prodId'];
}
include_once '../utils/dbConnect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/product.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>

<body>
    <?php
    // Initialize the session
    session_start();
    $isLogged = 0;
    // Check if the user is logged in, show registered header if not then redirect show unregistered header
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        include '../components/unreg_header.php';
    } else {
        include '../components/reg_header.php';
        $isLogged = 1;
    }
    $conn = OpenCon();
    $product = "NVidea TRX 6600";

    $sql = "SELECT * FROM `product` WHERE id = '$productId' ";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    $product_name = $row['product_name'];
    $description = $row['description'];
    $brand = $row['brand'];
    $version = $row['version'];
    $category = $row['category'];
    $price = $row['price'];
    $discount = $row['discount'];
    $ratings = $row['ratings'];
    $image1 = $row['image1'];
    $image2 = $row['image2'];
    $image3 = $row['image3'];
    $image4 = $row['image4'];
    ?>

    <div class="product-outer-container">
        <div class="product-header-container">
            <img class="product-img" src="../../resources/images/repairs.png" alt="cart icon" />
            <span class="product-header"><?php echo $product_name ?></span>
        </div>
        <div class="product-body-container">
            <div class="images-desription-box">
                <div class="imgs-box">
                    <div class="slider-container">
                        <?php echo $productId; ?>
                        <div class="slider">
                            <?php
                            echo " <img class='item' src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                <img class='item' src='data:image;base64," . base64_encode($row['image2']) . "'alt='item img' />
                                <img class='item' src='data:image;base64," . base64_encode($row['image3']) . "'alt='item img' />
                                <img class='item' src='data:image;base64," . base64_encode($row['image4']) . "'alt='item img' />
                            ";
                            ?>
                            <!-- Add more items as needed -->
                        </div>
                        <div style="margin-top: 1rem;">
                            <button class="prev-button" onclick="prevSlide()"><img src="../../resources/images/prev-white.png" alt="Next" height="50px" width="auto" /></button>
                            <button class="next-button" onclick="nextSlide()"><img src="../../resources/images/next-white.png" alt="Next" height="50px" width="auto" /></button>
                        </div>
                        <div class="price-box">
                            <h2>Rs. <?php echo $price ?></h2>
                            <div class="rating-box">
                                <div class="rating">
                                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
                                </div>
                                <p id="ratingText">Rating: <span id="selectedRating"><?php echo $ratings ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="description-box">
                    <div class="data-box">
                        <h2 style="margin-bottom: 2rem;">Product Description</h2>
                        <div class="desc"><label for="name">Name : </label><span id="name"><?php echo $product_name ?></span></div>
                        <div class="desc"><label for="brand">Brand : </label><span id="brand">Brand</span></div>
                        <div class="desc"><label for="version">Version : </label><span id="version">Version</span></div>
                        <div class="desc"><label for="category">Category : </label><span id="category">Category</span></div>
                        <div class="desc"><label for="description">Description : </label><span id="description"><?php echo $description ?></span></div>
                    </div>
                    <div class="button-box">
                        <button class="btn" onclick="addToWishList(<?php echo $productId ?>, <?php echo $isLogged ?>)">
                            <img src="../../resources/images/heart-white.png" alt="Next" height="15px" width="auto" style="margin-right: 5px;" />
                            Add to Wishlist
                        </button>
                        <button class="btn" onclick="addToCart(<?php echo $productId ?>, <?php echo $isLogged ?>)">
                            <img src="../../resources/images/cart-white.png" alt="Next" height="15px" width="auto" style="margin-right: 5px;" />
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            <div class="similar-products-carousel">
                <h3>Previous build PC recommendations</h3>
                <div class="similar-slider-container">
                    <div class="similar-slider">
                        <?php
                        include_once '../utils/dbConnect.php';
                        $conn = OpenCon();
                        $sql = "SELECT image1 FROM build_recommendations";
                        if ($result = mysqli_query($conn, $sql)) {

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {

                                    echo "<div class='similar-item'>
                                        <img class='img' src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    </div>";
                                }
                            }
                            CloseCon($conn);
                        }
                        ?>
                        <!-- Add more items as needed -->
                    </div>
                    <button class="similar-prev-button"><img src="../../resources/images/prev-white.png" alt="Next" height="30px" width="auto" onclick="prevProd()" /></button>
                    <button class="similar-next-button"><img src="../../resources/images/next-white.png" alt="Next" height="30px" width="auto" onclick="nextProd()" /></button>
                </div>
            </div>
            <div class="review-box">

                <div class="review-form">
                    <h2>Write a Review</h2>
                    <form id="reviewForm">
                        <input type="text" id="name" placeholder="Your Name" required>
                        <textarea id="reviewText" placeholder="Your Review" required></textarea>
                        <button type="submit">Submit</button>
                    </form>
                </div>
                <div class="reviews">
                    <h2>Customer Reviews</h2>
                    <ul id="reviewList">
                        <!-- Reviews will be displayed here using JavaScript and PHP -->
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <?php include '../components/footer.php'
    ?>

    <script src="../../resources/js/product.js"></script>
    <script>
        function addToWishList(productID, isLogged) {
            if (isLogged == 0) {
                window.location.href = "../pages/login.php";
            } else {
                var formData = new FormData();
                formData.append("productID", productID);

                var req = getXmlHttpRequestObject();
                if (req) {
                    req.onreadystatechange = function() {
                        if (req.readyState == 4) {
                            if (req.status == 200) {
                                if (req.responseText == 1) {
                                    window.location.href = "../pages/wishlist.php";
                                } else if (req.responseText == 0) {
                                    alert("Cannot redirect to page");
                                } else {
                                    alert(req.responseText);
                                }
                            }
                        }
                    };
                    req.open("POST", "../components/sub_wishlist.php", true);
                    req.send(formData);
                }
            }

        }

        function addToCart(productID, isLogged) {
            if (isLogged == 0) {
                window.location.href = "../pages/login.php";
            } else {
                var formData = new FormData();
                formData.append("productID", productID);

                var req = getXmlHttpRequestObject();
                if (req) {
                    req.onreadystatechange = function() {
                        if (req.readyState == 4) {
                            if (req.status == 200) {
                                if (req.responseText == 1) {
                                    window.location.href = "../pages/cart.php";
                                } else if (req.responseText == 0) {
                                    alert("Cannot redirect to page");
                                } else {
                                    alert(req.responseText);
                                }
                            }
                        }
                    };
                    req.open("POST", "../components/sub_cart.php", true);
                    req.send(formData);
                }
            }
        }

        function getXmlHttpRequestObject() {
            if (window.XMLHttpRequest) {
                return new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                return new ActiveXObject("Microsoft.XMLHTTP");
            } else {}
        }
    </script>
</body>

</html>