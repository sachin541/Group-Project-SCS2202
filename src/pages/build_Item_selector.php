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
    // $id1 = 20;
    // $id2 = 21;
    // $id3 = -1;
    // $id4 = -1;
    // $id5 = -1;
    // $id6 = 20;
    // $id7 = -1;
    
    $id1 = isset($_SESSION['CPU']) ? intval($_SESSION['CPU']) : -1;
    $id2 = isset($_SESSION['GPU']) ? intval($_SESSION['GPU']) : -1;
    $id3 = isset($_SESSION['MotherBoard']) ? intval($_SESSION['MotherBoard']) : -1;
    $id4 = isset($_SESSION['Memory']) ? intval($_SESSION['Memory']) : -1;
    $id5 = isset($_SESSION['Storage']) ? intval($_SESSION['Storage']) : -1;
    $id6 = isset($_SESSION['PowerSupply']) ? intval($_SESSION['PowerSupply']) : -1;
    $id7 = isset($_SESSION['Case']) ? intval($_SESSION['Case']) : -1;
    
    

    $productIds = [$id1,$id2,$id3,$id4,$id5,$id6,$id7]; // Include -1 in the array for demonstration
    $items = ["CPU","GPU","Mother Board","Memory","Storage","Power Supply","Case"];
    $i = 0;
    foreach ($productIds as $id) {
        $title = $items[$i];
        $i++;
        if ($id == -1) {
            
            echo '<form method="post" action="./build_parts.php">';
            echo '<div class="product-title">' . htmlspecialchars($title) . '</div>';
            echo '<div class="main-row2" onclick="submitForm(this);">';
            echo '<div class="product-row2">';
           
            echo '<img src="../../resources/images/plus.png"/>';
            echo '<div class="product-info2">';
            echo '<span>Select ' . htmlspecialchars($title) . '</span>';
            echo '</div>'; // product-info

            echo '<div class="product-actions">';
            // Hidden input to send the product ID
            echo '<input type="hidden" name="category" value="' . htmlspecialchars($title) . '"/>';
            echo '</div>'; // product-actions
            echo '</div>'; // product-row
            echo '</div>'; // main-row2
            echo '</form>';
                        
            
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
                echo '<span>Price: Rs.' . htmlspecialchars($productDetails['price']) . '</span>';
                //change item
                echo '<form method="post" action="./build_parts.php">';
                echo '<input type="hidden" name="category" value="' . htmlspecialchars($title) . '"/>';
                echo '<button type="submit" class="change-btn">Change</button>';
                echo '</form>';

                //remove item 
                echo '<form method="post" action="../helpers/build_create.php">';
                echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id) . '"/>';
                echo '<input type="hidden" name="item_type" value="' . htmlspecialchars($title) . '">';
                echo '<input type="hidden" name="handler_type" value="remove_item">';
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


<script>
function submitForm(element) {
    element.closest('form').submit();
}
</script>



