<?php
require_once '../classes/database.php'; 
require_once '../classes/product.php';
 
require_once '../classes/staff.php';
session_start();

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
        
        // $image1 = file_get_contents($_FILES['image1']['tmp_name']);
        // $image2 = file_get_contents($_FILES['image2']['tmp_name']);
        // $image3 = file_get_contents($_FILES['image3']['tmp_name']);
        $image1 = isset($_FILES['image1']['tmp_name']) && is_uploaded_file($_FILES['image1']['tmp_name']) ? file_get_contents($_FILES['image1']['tmp_name']) : null;
        $image2 = isset($_FILES['image2']['tmp_name']) && is_uploaded_file($_FILES['image2']['tmp_name']) ? file_get_contents($_FILES['image2']['tmp_name']) : null;
        $image3 = isset($_FILES['image3']['tmp_name']) && is_uploaded_file($_FILES['image3']['tmp_name']) ? file_get_contents($_FILES['image3']['tmp_name']) : null;
    

        try {
            $productId = $staff->addProduct($productName, $category, $quantity, $description, $price, $discount, $brand, $image1, $image2, $image3);

            if ($productId) {
                echo "New product added successfully.";
                
                $_SESSION['product_adder'] = 'New product added successfully.';
                header('Location: ../views_staff/add_product.php');
            } else {
                echo "Failed to add new product.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['formType'] == "delete_product") {
        $productId = $_POST['product_id'];
        $_SESSION["category"] = $_POST['category'];
        $database = new Database();
        $db = $database->getConnection(); 
        $staffManager = new Staff();

        if ($staffManager->deleteProduct($productId)) {
            // Redirect or display success message
            header('Location: ../views_staff/product_list.php');
            exit;
        } else {
            // Error handling
            echo "Failed to delete product.";
        }
    }


    if (isset($_POST['product_id']) && isset($_POST['quantity']) && $_POST['formType'] == "update_qty") {
        $database = new Database();
        $db = $database->getConnection();
        $product = new Staff();
        
        $_SESSION["category"] = $_POST['category'];
        echo $_SESSION["category"]; 
        $productId = $_POST['product_id'];
        $newQuantity = max(0, $_POST['quantity']); // Ensures stock is not negative
    
        $product->updateProductStock($productId, $newQuantity);
    
        // Redirect back to the product list page
        header('Location: ../views_staff/product_list.php');
        exit;
    }




?>
