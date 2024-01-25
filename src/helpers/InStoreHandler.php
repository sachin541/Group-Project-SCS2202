<?php
require_once '../classes/database.php'; 
require_once '../classes/InStore.php';

session_start();

$database = new Database();
$db = $database->getConnection();

$inStore = new InStore($db);
echo $_POST['product_id'];

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/login.php');
    exit;
}

if (isset($_POST['product_id']) && isset($_POST['remove_from_instore'])) {
    $productId = $_POST['product_id'];
    $staffId = $_SESSION['user_id'];

    // Delete from in-store
    $inStore->deleteFromInStore($staffId, $productId);

    // Redirect back to the in-store page
    header('Location: ../views_staff/InStoreOrder.php');
    exit;
}

if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['update_instore_qty'])) {
    $productId = $_POST['product_id'];
    $quantity = max(1, $_POST['quantity']); // Ensures quantity is at least 1
    $staffId = $_SESSION['user_id'];

    // Update the in-store
    $inStore->updateInStoreQuantity($staffId, $productId, $quantity);

    // Redirect back to the in-store page
    header('Location: ../views_staff/InStoreOrder.php');
    exit;
}

if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['add_to_order'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $staffId = $_SESSION['user_id']; 
    
    // Add to in-store
    $inStore->addToInStore($staffId, $productId, $quantity);

    // Redirect to in-store page
    header('Location: ../views_staff/InStoreOrder.php');
    exit;
}

// Redirect to product list if the required POST data isn't set
header('Location: ../views_staff/product_list.php');
exit;
?>
