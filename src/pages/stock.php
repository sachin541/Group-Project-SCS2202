<?php
// Initialize the session
session_start();
$staff_id = "";
// Check if the user is already logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "staff") {
    header("location: login.php");
    exit;
} else {
    $staff_id = $_SESSION["id"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Stocks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/stock.css" type="text/css">
</head>

<body>
    <?php include '../components/reg_header.php'
    ?>
    <div class="stock-outer-container">
        <div class="stock-inner inner-1">
            <div class="stock-selectors">

                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" class="form-control">
                        <option value="" selected>Select Category</option>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<option value="' . $i . '">Category ' . $i . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand" class="form-label">Brand</label>
                    <select id="brand" class="form-control">
                        <option value="" selected>Select Brand</option>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<option value="' . $i . '">Brand ' . $i . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="item" class="form-label">Item</label>
                    <select id="item" class="form-control">
                        <option value="" selected>Select Item</option>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<option value="' . $i . '">Item ' . $i . '</option>';
                        }
                        ?>
                    </select>
                </div>

            </div>
            <div class="stock-details-box">
                <h3>Stock Details</h3>
            </div>
            <div class="stock-note-box">
                <h3>Special Notes</h3>
            </div>
        </div>
        <div class="stock-inner inner-2">
            <div class="stock-arival-dates-box">
                <h3>New Stock Arrival Dates</h3>
            </div>
            <div class="stock-level-box">
                <h3>Current Stock Levels</h3>
            </div>
            <div class="button-set">
                <button class="btn" id="new-category">New Category</button>
                <button class="btn" id="new-brand">New Brand</button>
                <button class="btn" id="new-prod">New Product</button>
            </div>
        </div>
    </div>

    <!-- New Category modal -->
    <div id="new-c" class="modal">
        <div class="modal-content">
            <span class="close" id="close-c">&times;</span>
            <h3>New Category</h3>
            <form action="new_category.php" method="POST">
                <div class="modal-form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="modal-form-control" placeholder="Enter category name" id="name" />
                </div>
                <div class="modal-form-group">
                    <label for="address">Description</label>
                    <input type="text" name="address" class="modal-form-control" placeholder="Enter description" id="address" />
                </div>
                <div class="modal-form-group">
                    <input type="submit" name="submit" class="modal-submit-btn" />
                </div>
            </form>
        </div>
    </div>

    <!-- New Brand modal -->
    <div id="new-b" class="modal">
        <div class="modal-content">
            <span class="close" id="close-b">&times;</span>
            <h3>New Brand</h3>
            <form action="new_brand.php" method="POST">
                <div class="modal-form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="modal-form-control" placeholder="Enter brand name" id="name" />
                </div>
                <div class="modal-form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" class="modal-form-control" placeholder="Enter description" id="description" />
                </div>
                <div class="modal-form-group">
                    <input type="submit" name="submit" class="modal-submit-btn" />
                </div>
            </form>
        </div>
    </div>

    <!-- New Product modal -->
    <div id="new-p" class="modal">
        <div class="modal-content">
            <span class="close" id="close-p">&times;</span>
            <h3>New Product</h3>
            <form action="new_prod.php" method="POST">
                <div class="modal-form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="modal-form-control" placeholder="Enter brand name" id="name" />
                </div>
                <div class="modal-form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" class="modal-form-control" placeholder="Enter description" id="address" />
                </div>
                <div class="modal-form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" class="modal-form-control" placeholder="Enter price" id="price" />
                </div>
                <div class="modal-form-group">
                    <label for="category">Category</label>
                    <select name="category" class="modal-form-control" placeholder="Select category" id="category">
                        <option>Select category</option>
                    </select>
                </div>
                <div class="modal-form-group">
                    <label for="brand">Brand</label>
                    <select name="brand" class="modal-form-control" placeholder="Select brand" id="brand">
                        <option>Select brand</option>
                    </select>
                </div>
                <div class="modal-form-group">
                    <input type="submit" name="submit" class="modal-submit-btn" />
                </div>
            </form>
        </div>
    </div>

    <?php include '../components/footer.php'
    ?>

    <script src="../../resources/js/stock.js"></script>
</body>

</html>