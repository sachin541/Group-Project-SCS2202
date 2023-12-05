<!DOCTYPE html>
<html>
<head>
    <title>Product Display</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/builds.css">
</head>
<body>
<div class="main-container">
    <?php 
    require_once '../classes/product.php';
    require_once '../classes/database.php';
    require_once '../components/headers/main_header.php';
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);
    $id1 = 20;
    $id2 = 21;
    $id3 = -1;
    $id4 = -1;
    $id5 = -1;
    $id6 = 20;
    $id7 = -1;
    

    $productIds = [$id1,$id2,$id3,$id4,$id5,$id6,$id7]; // Include -1 in the array for demonstration
    $items = ["CPU","GPU","Mother Board","Memory","Storage","Power Supply","Case"];
    $i = 0;
    foreach ($productIds as $id) {
        $title = $items[$i];
        $i++;
        if ($id == -1) {
            echo '<div class="product-title">'. htmlspecialchars($title) .'</div>';
            echo '<div class="main-row2">'; 
            echo '<div class="product-row2">';
             // Hardcoded title
            echo '<img src="../../resources/images/plus.png"/>';
            echo '<div class="product-info2">';
            echo '<span>Select '. htmlspecialchars($title) .'</span>';
            echo '</div>'; // product-info
            
            echo '<div class="product-actions">';
            // echo '<span>ITEM</span>';
            echo '<form method="post" action="your_post_handler.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id) . '"/>';
            
            echo '</form>';

            
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>';
        } else {
            $productDetails = $product->getProductById($id);
            echo '<div class="product-title">'. htmlspecialchars($title) .'</div>';
            if ($productDetails) {
                echo '<div class="main-row">'; 
                echo '<div class="product-row">';
                if ($productDetails['image1']) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($productDetails['image1']) . '"/>';
                }
                echo '<div class="product-info">';
                echo '<span>' . htmlspecialchars($productDetails['product_name']) . '</span>';
                echo '</div>'; // product-info
                
                echo '<div class="product-actions">';
                echo '<span>Price: $' . htmlspecialchars($productDetails['price']) . '</span>';

                echo '<form method="post" action="your_post_handler.php">';
                echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id) . '"/>';
                echo '<button type="submit" class="change-btn">Change</button>';
                echo '</form>';

                echo '<form method="post" action="your_post_handler.php">';
                echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id) . '"/>';
                echo '<button type="submit" class="remove-btn">Remove</button>';
                echo '</form>';

                echo '</div>'; // product-actions
                echo '</div>'; // product-row
                echo '</div>';
            }
        }
    }
    ?>
</div>
</body>
</html>



