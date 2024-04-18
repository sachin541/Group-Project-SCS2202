<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" href="/resources/css/builds.css"> <!-- Update the href with correct path -->


<div class="main-container">
    <?php
    require_once '../classes/product.php';
    require_once '../classes/database.php';

    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    $productIds = [-1, 17, 18, 19, 20]; // Example product IDs. Replace with actual IDs or GET request
    
    $id1 = 17;
    if ($id1 == -1) {
        echo '<div class="product-title">Title</div>';
        echo '<div class="main-row2">';
        echo '<div class="product-row2">';
        // Hardcoded title
        echo '<img src="../../resources/images/plus.png"/>';
        echo '<div class="product-info2">';
        echo '<span>SELECT GPU</span>';
        echo '</div>'; // product-info
    
        echo '<div class="product-actions">';
        // echo '<span>ITEM</span>';
        echo '<form method="post" action="your_post_handler.php">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id1) . '"/>';

        echo '</form>';
        echo '</div>'; // product-actions
        echo '</div>'; // product-row
        echo '</div>';
    } else {
        $productDetails = $product->getProductById($id1);
        echo '<div class="product-title">Special Offer</div>';
        if ($productDetails) {
            echo '<div class="main-row">';
            echo '<div class="product-row">';
            // Hardcoded title
            if ($productDetails['image1']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
            }
            echo '<div class="product-info">';
            echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
            echo '</div>'; // product-info
    
            echo '<div class="product-actions">';
            echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id1) . '"/>';
            echo '<button type="submit" class="change-btn">Change</button>';
            echo '</form>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        }
    }


    $id2 = -1;
    if ($id2 == -1) {
        echo '<div class="product-title">Title</div>';
        echo '<div class="main-row2">';
        echo '<div class="product-row2">';
        // Hardcoded title
        echo '<img src="../../resources/images/plus.png"/>';
        echo '<div class="product-info2">';
        echo '<span>SELECT GPU</span>';
        echo '</div>'; // product-info
    
        echo '<div class="product-actions">';
        // echo '<span>ITEM</span>';
        echo '<form method="post" action="your_post_handler.php">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id2) . '"/>';

        echo '</form>';
        echo '</div>'; // product-actions
        echo '</div>'; // product-row
        echo '</div>';
    } else {
        $productDetails = $product->getProductById($id1);
        echo '<div class="product-title">Special Offer</div>';
        if ($productDetails) {
            echo '<div class="main-row">';
            echo '<div class="product-row">';
            // Hardcoded title
            if ($productDetails['image1']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
            }
            echo '<div class="product-info">';
            echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
            echo '</div>'; // product-info
    
            echo '<div class="product-actions">';
            echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id1) . '"/>';
            echo '<button type="submit" class="change-btn">Change</button>';
            echo '</form>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        }
    }


    $id3 = 17;
    if ($id3 == -1) {
        echo '<div class="product-title">Title</div>';
        echo '<div class="main-row2">';
        echo '<div class="product-row2">';
        // Hardcoded title
        echo '<img src="../../resources/images/plus.png"/>';
        echo '<div class="product-info2">';
        echo '<span>SELECT GPU</span>';
        echo '</div>'; // product-info
    
        echo '<div class="product-actions">';
        // echo '<span>ITEM</span>';
        echo '<form method="post" action="your_post_handler.php">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id3) . '"/>';

        echo '</form>';
        echo '</div>'; // product-actions
        echo '</div>'; // product-row
        echo '</div>';
    } else {
        $productDetails = $product->getProductById($id3);
        echo '<div class="product-title">Special Offer</div>';
        if ($productDetails) {
            echo '<div class="main-row">';
            echo '<div class="product-row">';
            // Hardcoded title
            if ($productDetails['image1']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
            }
            echo '<div class="product-info">';
            echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
            echo '</div>'; // product-info
    
            echo '<div class="product-actions">';
            echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id3) . '"/>';
            echo '<button type="submit" class="change-btn">Change</button>';
            echo '</form>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        }
    }


    $id4 = 17;
    if ($id4 == -1) {
        echo '<div class="product-title">Title</div>';
        echo '<div class="main-row2">';
        echo '<div class="product-row2">';
        // Hardcoded title
        echo '<img src="../../resources/images/plus.png"/>';
        echo '<div class="product-info2">';
        echo '<span>SELECT GPU</span>';
        echo '</div>'; // product-info
    
        echo '<div class="product-actions">';
        // echo '<span>ITEM</span>';
        echo '<form method="post" action="your_post_handler.php">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id4) . '"/>';

        echo '</form>';
        echo '</div>'; // product-actions
        echo '</div>'; // product-row
        echo '</div>';
    } else {
        $productDetails = $product->getProductById($id4);
        echo '<div class="product-title">Special Offer</div>';
        if ($productDetails) {
            echo '<div class="main-row">';
            echo '<div class="product-row">';
            // Hardcoded title
            if ($productDetails['image1']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
            }
            echo '<div class="product-info">';
            echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
            echo '</div>'; // product-info
    
            echo '<div class="product-actions">';
            echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id4) . '"/>';
            echo '<button type="submit" class="change-btn">Change</button>';
            echo '</form>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        }
    }


    $id5 = 17;
    if ($id5 == -1) {
        echo '<div class="product-title">Title</div>';
        echo '<div class="main-row2">';
        echo '<div class="product-row2">';
        // Hardcoded title
        echo '<img src="../../resources/images/plus.png"/>';
        echo '<div class="product-info2">';
        echo '<span>SELECT GPU</span>';
        echo '</div>'; // product-info
    
        echo '<div class="product-actions">';
        // echo '<span>ITEM</span>';
        echo '<form method="post" action="your_post_handler.php">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id5) . '"/>';

        echo '</form>';
        echo '</div>'; // product-actions
        echo '</div>'; // product-row
        echo '</div>';
    } else {
        $productDetails = $product->getProductById($id5);
        echo '<div class="product-title">Special Offer</div>';
        if ($productDetails) {
            echo '<div class="main-row">';
            echo '<div class="product-row">';
            // Hardcoded title
            if ($productDetails['image1']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
            }
            echo '<div class="product-info">';
            echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
            echo '</div>'; // product-info
    
            echo '<div class="product-actions">';
            echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id5) . '"/>';
            echo '<button type="submit" class="change-btn">Change</button>';
            echo '</form>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        }
    }


    $id6 = 17;
    if ($id6 == -1) {
        echo '<div class="product-title">Title</div>';
        echo '<div class="main-row2">';
        echo '<div class="product-row2">';
        // Hardcoded title
        echo '<img src="../../resources/images/plus.png"/>';
        echo '<div class="product-info2">';
        echo '<span>SELECT GPU</span>';
        echo '</div>'; // product-info
    
        echo '<div class="product-actions">';
        // echo '<span>ITEM</span>';
        echo '<form method="post" action="your_post_handler.php">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id6) . '"/>';

        echo '</form>';
        echo '</div>'; // product-actions
        echo '</div>'; // product-row
        echo '</div>';
    } else {
        $productDetails = $product->getProductById($id6);
        echo '<div class="product-title">Special Offer</div>';
        if ($productDetails) {
            echo '<div class="main-row">';
            echo '<div class="product-row">';
            // Hardcoded title
            if ($productDetails['image1']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
            }
            echo '<div class="product-info">';
            echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
            echo '</div>'; // product-info
    
            echo '<div class="product-actions">';
            echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id6) . '"/>';
            echo '<button type="submit" class="change-btn">Change</button>';
            echo '</form>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        }
    }


    $id7 = 17;
    if ($id7 == -1) {
        echo '<div class="product-title">Title</div>';
        echo '<div class="main-row2">';
        echo '<div class="product-row2">';
        // Hardcoded title
        echo '<img src="../../resources/images/plus.png"/>';
        echo '<div class="product-info2">';
        echo '<span>SELECT GPU</span>';
        echo '</div>'; // product-info
    
        echo '<div class="product-actions">';
        // echo '<span>ITEM</span>';
        echo '<form method="post" action="your_post_handler.php">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id7) . '"/>';

        echo '</form>';
        echo '</div>'; // product-actions
        echo '</div>'; // product-row
        echo '</div>';
    } else {
        $productDetails = $product->getProductById($id7);
        echo '<div class="product-title">Special Offer</div>';
        if ($productDetails) {
            echo '<div class="main-row">';
            echo '<div class="product-row">';
            // Hardcoded title
            if ($productDetails['image1']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
            }
            echo '<div class="product-info">';
            echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
            echo '</div>'; // product-info
    
            echo '<div class="product-actions">';
            echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id7) . '"/>';
            echo '<button type="submit" class="change-btn">Change</button>';
            echo '</form>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        }
    }


    $id8 = 17;
    if ($id1 == -1) {
        echo '<div class="product-title">Title</div>';
        echo '<div class="main-row2">';
        echo '<div class="product-row2">';
        // Hardcoded title
        echo '<img src="../../resources/images/plus.png"/>';
        echo '<div class="product-info2">';
        echo '<span>SELECT GPU</span>';
        echo '</div>'; // product-info
    
        echo '<div class="product-actions">';
        // echo '<span>ITEM</span>';
        echo '<form method="post" action="your_post_handler.php">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id8) . '"/>';

        echo '</form>';
        echo '</div>'; // product-actions
        echo '</div>'; // product-row
        echo '</div>';
    } else {
        $productDetails = $product->getProductById($id8);
        echo '<div class="product-title">Special Offer</div>';
        if ($productDetails) {
            echo '<div class="main-row">';
            echo '<div class="product-row">';
            // Hardcoded title
            if ($productDetails['image1']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
            }
            echo '<div class="product-info">';
            echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
            echo '</div>'; // product-info
    
            echo '<div class="product-actions">';
            echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id8) . '"/>';
            echo '<button type="submit" class="change-btn">Change</button>';
            echo '</form>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        }
    }


    $id9 = 17;
    if ($id9 == -1) {
        echo '<div class="product-title">Title</div>';
        echo '<div class="main-row2">';
        echo '<div class="product-row2">';
        // Hardcoded title
        echo '<img src="../../resources/images/plus.png"/>';
        echo '<div class="product-info2">';
        echo '<span>SELECT GPU</span>';
        echo '</div>'; // product-info
    
        echo '<div class="product-actions">';
        // echo '<span>ITEM</span>';
        echo '<form method="post" action="your_post_handler.php">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id9) . '"/>';

        echo '</form>';
        echo '</div>'; // product-actions
        echo '</div>'; // product-row
        echo '</div>';
    } else {
        $productDetails = $product->getProductById($id9);
        echo '<div class="product-title">Special Offer</div>';
        if ($productDetails) {
            echo '<div class="main-row">';
            echo '<div class="product-row">';
            // Hardcoded title
            if ($productDetails['image1']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
            }
            echo '<div class="product-info">';
            echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
            echo '</div>'; // product-info
    
            echo '<div class="product-actions">';
            echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id9) . '"/>';
            echo '<button type="submit" class="change-btn">Change</button>';
            echo '</form>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        }
    }






    ?>
</div>

<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>