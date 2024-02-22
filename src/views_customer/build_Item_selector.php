<?php
require_once '../classes/product.php';
require_once '../classes/database.php';
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);


$items = ["CPU", "GPU", "MotherBoard", "Memory", "Storage", "PowerSupply", "Case"];

?>

<!-- Template Top -->
<?php require_once '../templates/main_top.php'; ?>

<!-- Stylesheets -->
<link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/builds_select_componets.css">

</head>

<>

    <!-- Header -->
    <?php require_once '../templates/main_header.php'; ?>

    <?php ?>
    <div class="heading">
        <p>Create Your Own PC Build!</p>
    </div>

    <div class="main-container">
        <?php foreach ($items as $item) {
            $id = isset($_SESSION[$item]) ? intval($_SESSION[$item]) : -1;

            if ($id == -1) { ?>
                <form method="post" action="./build_parts.php">
                    <div class="product-title">
                        <?= htmlspecialchars($item) ?>
                    </div>
                    <div class="main-row2" onclick="submitForm(this);">
                        <div class="product-row2">
                            <img src="../../resources/images/plus.png" />
                            <div class="product-info2">
                                <span>Select
                                    <?= htmlspecialchars($item) ?>
                                </span>
                            </div>
                            <div class="product-actions">
                                <input type="hidden" name="category" value="<?= htmlspecialchars($item) ?>" />
                            </div>
                        </div>
                    </div>
                </form>
            <?php } else {
                $productDetails = $product->getProductById($id);
                if ($productDetails) { ?>
                    <div class="product-title">
                        <?= htmlspecialchars($item) ?>
                    </div>
                    <div class="main-row">
                        <div class="product-row">
                            <?php if ($productDetails['image1']) { ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($productDetails['image1']) ?>" />
                            <?php } ?>
                            <div class="product-info">
                                <span>
                                    <?= htmlspecialchars($productDetails['product_name']) ?>
                                </span>
                            </div>
                            <div class="product-actions">
                                <span>Price: Rs.
                                    <?= htmlspecialchars($productDetails['price']) ?>
                                </span>
                                <form method="post" action="./build_parts.php">
                                    <input type="hidden" name="category" value="<?= htmlspecialchars($item) ?>" />
                                    <button type="submit" class="change-btn">Change</button>
                                </form>
                                <form method="post" action="../helpers/build_create.php">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($id) ?>" />
                                    <input type="hidden" name="item_type" value="<?= htmlspecialchars($item) ?>">
                                    <input type="hidden" name="handler_type" value="remove_item">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
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
            <form method="post" action="./builds_current.php">
                <input type="hidden" name="handler_type" value="submit-build">
                <button type="submit" class="remove-btn">View Active Build Requets!</button>
            </form>
        </div>
    </div>

    <script>
        function submitForm(element) {
            element.closest('form').submit();
        }
    </script>

    <!-- Footer -->
    <?php require_once '../templates/main_footer.php'; ?>

    <!-- Template Bottom -->
    <?php require_once '../templates/main_bottom.php'; ?>