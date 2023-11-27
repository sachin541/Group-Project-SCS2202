<?php
require_once '../classes/database.php'; 
require_once '../classes/product.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formType'] == 'addProduct') {

        $database = new Database();
        $db = $database->getConnection();

        $staff = new Product($db);

        $productName = $_POST['product_name'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $description = $_POST['product_description'];
        $price = $_POST['price'];
        $discount = $_POST['discount'];
        $brand = $_POST['brand'];
        // Image handling will depend on how you are planning to upload images
        // For simplicity, we're assuming images are being sent as binary data
        $image1 = file_get_contents($_FILES['image1']['tmp_name']);
        $image2 = file_get_contents($_FILES['image2']['tmp_name']);
        $image3 = file_get_contents($_FILES['image3']['tmp_name']);

        try {
            $productId = $staff->addProduct($productName, $category, $quantity, $description, $price, $discount, $brand, $image1, $image2, $image3);

            if ($productId) {
                echo "New product added successfully.";
                session_start();
                $_SESSION['product_adder'] = 'New product added successfully.';
                header('Location: ../pages/add_product.php');
            } else {
                echo "Failed to add new product.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


?>
