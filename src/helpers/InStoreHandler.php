<?php
require_once '../classes/database.php'; 
require_once '../classes/InStore.php';
require_once '../classes/product.php';

session_start();

$database = new Database();

$db = $database->getConnection();

$product = new Product($db);
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

if (isset($_POST['check_qty'])) {
    $userId = $_SESSION['user_id']; 

        $cartItems = $inStore->getInStoreItemsByUserId($userId);

        $allItemsInStock = true;
        $outOfStockItems = [];

        foreach ($cartItems as $item) {
            $productId = $item['id'];
            $requestedQuantity = $item['quantity'];

            // Check available stock
            $productDetails = $product->getProductById($productId);
            $availableStock = $productDetails['quantity'];

            if ($requestedQuantity > $availableStock) {
                $allItemsInStock = false;
                $outOfStockItems[] = $item['product_name']; 
            }
        }

        if (!$allItemsInStock) {
            
            
            $_SESSION['out_of_stock_message'] = implode(", ", $outOfStockItems);
            header('Location: ../views_staff/InStoreOrder.php');

            exit;
        }

        header('Location: ../views_staff/confirmOrder.php');
        exit;
}


if (isset($_POST['Instore_order'])) {
    try {
        $userId = $_SESSION['user_id']; 
        $cartItems = $inStore->getInStoreItemsByUserId($userId);
        $orderId = $inStore->ConfirmInStoreOrder($userId, $_POST, $cartItems);
        $inStore->updateInStoreProductQuantities($userId);
        $inStore->clearInStore($userId);
        header('Location: ../views_customer/order_success.php?order_id=' . $orderId);

        exit;
        

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}



// Redirect to product list if the required POST data isn't set
header('Location: ../views_staff/product_list.php');
exit;
?>
