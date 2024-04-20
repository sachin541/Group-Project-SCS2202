<?php
require_once '../classes/product.php';
require_once '../classes/database.php';
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// Updated items array with optional items indicated
$items = [
    "CPU", 
    "GPU", 
    "MotherBoard", 
    "CPU Coolers",
    "Memory", 
    "Storage", 
    "PowerSupply", 
    "Case",
     // Added CPU Coolers
    ["Monitor", "optional"], // Marked Monitors as optional
    ["Mouse", "optional"], // Marked Mouse as optional
    ["Keyboard", "optional"] // Marked Keyboard as optional
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Display</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/builds_select_componets.css">
</head>
<body>

    <div class="heading">
    <p>Create Your Own PC Build!</p>
    </div>
    <div class="error-box">
    <?php if (isset($_SESSION['error'])): ?>
    <div class="error-message">
        <?= $_SESSION['error']; ?>
        <?php unset($_SESSION['error']); // Clear the error message after displaying it ?>
    </div>
    <?php endif; ?>
    </div>   
    
    <div class="main-container">
        <?php foreach ($items as $item) {
            // Check if item is an array to determine if it's marked optional
            $isOptional = is_array($item);
            $itemName = $isOptional ? $item[0] : $item; // Get the item name
            $optionalText = $isOptional ? " (Optional)" : ""; // Set optional text if needed

            $id = isset($_SESSION[$itemName]) ? intval($_SESSION[$itemName]) : -1;
            
            if ($id == -1) { ?>
            <div class="item"> 

                <form method="post" action="./build_parts.php">
                    <div class="product-title"><?= htmlspecialchars($itemName) . $optionalText ?></div>
                    <div class="main-row2" onclick="submitForm(this);">
                        <div class="product-row2">
                            <img src="../../resources/images/plus.png"/>
                            <div class="product-info2">
                                <span>Select <?= htmlspecialchars($itemName) ?></span>
                            </div>
                            <div class="product-actions">
                                <input type="hidden" name="category" value="<?= htmlspecialchars($itemName) ?>"/>
                            </div>
                        </div>
                    </div>
                </form>

            </div>   
            <?php } else {
                $productDetails = $product->getProductById($id);
                if ($productDetails) { ?>
                <div class="item"> 

                    <div class="product-title"><?= htmlspecialchars($itemName) . $optionalText ?></div>
                    <div class="main-row">
                        <div class="product-row">
                            <?php if ($productDetails['image1']) { ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($productDetails['image1']) ?>"/>
                            <?php } ?>
                            <div class="product-info">
                                <span><?= htmlspecialchars($productDetails['product_name']) ?></span>
                            </div>
                            <div class="product-actions">
                                <span>Price: Rs.<?= htmlspecialchars($productDetails['price']) ?></span>
                                <form method="post" action="./build_parts.php">
                                    <input type="hidden" name="category" value="<?= htmlspecialchars($itemName) ?>"/>
                                    <button type="submit" class="change-btn">Change</button>
                                </form>
                                <form method="post" action="../helpers/build_create.php" class="remove-form">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($id) ?>"/>
                                    <input type="hidden" name="item_type" value="<?= htmlspecialchars($itemName) ?>">
                                    <input type="hidden" name="handler_type" value="remove_item">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div> 
                <?php }
            }
        } ?>
    </div>

    <div class="main-container-2">
        <div class="create-build-btn">
            <form method="post" action="./build_create.php">
                <input type="hidden" name="handler_type" value="submit-build">
                <button type="submit" class="remove-btn">Create New Build Request!</button>
            </form>
        </div>  

        <div class="view-current-build-btn">
            <a href="./builds_current.php" class="active-build-btn">View Active Build Requests!</a>
        </div>
    </div>



    
</body>
</html>


<script>
    function submitForm(element) {
        element.closest('form').submit();
    }
</script>