<?php


require_once '../classes/database.php';
require_once '../classes/cart.php';
require_once '../classes/product.php';

session_start();

$database = new Database();
$db = $database->getConnection();
// Assume $db is your database connection
$cart = new Cart($db);
$product = new Product($db);

$userId = $_POST['user_id'];
$cartItems = $cart->getCartItemsByUserId($userId);

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
        $outOfStockItems[] = $item['product_name']; // Add the product name to the list of out-of-stock items
    }
}

if (!$allItemsInStock) {
    
    
    $_SESSION['out_of_stock_message'] = implode(", ", $outOfStockItems);
    header('Location: ../views_customer/view_cart.php');

    exit;
} 
else {
    header('Location: ../views_customer/checkout.php');
}
?>
