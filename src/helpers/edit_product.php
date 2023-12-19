<?php
require_once '../classes/database.php';
require_once '../classes/staff.php';

session_start();

$database = new Database();
$db = $database->getConnection();
$product = new Staff();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'] ;
    $productName = $_POST['product_name'] ;
    $category = $_POST['category'] ;
    $quantity = $_POST['quantity'] ;
    $description = $_POST['product_description'] ;
    $price = $_POST['price'] ;
    $discount = $_POST['discount'] ;
    $brand = $_POST['brand'] ;

    $image1 = isset($_FILES['image1']['tmp_name']) && is_uploaded_file($_FILES['image1']['tmp_name']) ? file_get_contents($_FILES['image1']['tmp_name']) : null;
    $image2 = isset($_FILES['image2']['tmp_name']) && is_uploaded_file($_FILES['image2']['tmp_name']) ? file_get_contents($_FILES['image2']['tmp_name']) : null;
    $image3 = isset($_FILES['image3']['tmp_name']) && is_uploaded_file($_FILES['image3']['tmp_name']) ? file_get_contents($_FILES['image3']['tmp_name']) : null;

    // Validation here 
    if (empty($productName) || empty($category)) {
        $_SESSION['error'] = 'Product name and category are required.';
        header('Location: edit_product.php?product_id=' . $productId);
        exit;
    }

    try {
        $success = $product->updateProduct($productId, $productName, $category, $quantity, $description, $price, $discount, $brand, $image1, $image2, $image3);

        if ($success) {
            $_SESSION['message'] = 'Product updated successfully.';
        } else {
            $_SESSION['error'] = 'Failed to update product.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error: ' . $e->getMessage();
    }

    header('Location: ../views_staff/product_list.php');
    exit;
}


exit;
?>
