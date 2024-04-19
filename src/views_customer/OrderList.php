<?php
require_once '../classes/database.php'; 
require_once '../classes/order.php';

require_once '../components/headers/main_header.php';


$database = new Database();
$db = $database->getConnection();
$inStore = new Order($db);


if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/staff_login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : null;

$orders = $inStore->getAllOrders($filterBy=null, $sortBy); 

function formatString($str) {
    // Replace underscores with spaces
    $str = str_replace('_', ' ', $str);

    // Capitalize the first letter of each word
    $str = ucwords($str);

    return $str;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ...existing head elements... -->
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/ordersList.css" />
    
</head>
<body>
    <div class="orders-container">
        <h1 class="orders-header"><span>YOUR ORDERS</span></h1>
            <div class="filter-sort-container">
                <form action="" method="GET">
                    <select name="sortBy" class="filter-dropdown">
                        <option value="">Sort by</option>
                        <option value="date_asc" <?php echo $sortBy == 'date_asc' ? 'selected' : ''; ?>>Date Ascending</option>
                        <option value="date_desc" <?php echo $sortBy == 'date_desc' ? 'selected' : ''; ?>>Date Descending</option>
                        <option value="id_asc" <?php echo $sortBy == 'id_asc' ? 'selected' : ''; ?>>Order ID Ascending</option>
                        <option value="id_desc" <?php echo $sortBy == 'id_desc' ? 'selected' : ''; ?>>Order ID Descending</option>
                        <option value="total_asc" <?php echo $sortBy == 'total_asc' ? 'selected' : ''; ?>>Total Ascending</option>
                        <option value="total_desc" <?php echo $sortBy == 'total_desc' ? 'selected' : ''; ?>>Total Descending</option>
                    </select>
                    <button class="apply-filter-button">Apply Filter</button>
                </form>
            </div>
            <?php if (empty($orders)): ?><p class="no-orders-message">No orders found.</p><?php else: ?>
                <table class="orders-table">
                    <thead>
                        <tr class="table-header-row">
                            <th class="header-order-id">Order ID</th>
                            <th class="header-created-at">Created At</th>
                            <th class="header-payment-status">Payment Status</th>
                            <th class="header-total">Total (RS.)</th>
                            <th class="header-total">Delivery Status</th>
                            <th class="header-details">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr class="table-data-row">
                                <td class="td-order-id"><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td class="td-created-at"><?php echo date('Y-m-d', strtotime($order['created_at'])); ?></td>
                                <td class="td-payment-status"><?php echo htmlspecialchars(formatString($order['payment_status'])); ?></td>
                                <td class="td-total"><?php echo htmlspecialchars($order['total']); ?></td>
                                <td class="td-delivery-status"><?php echo htmlspecialchars(formatString($order['delivery_status'])); ?></td>
                                <td class="td-details"><a href="./OrderDetails.php?order_id=<?php echo $order['order_id']; ?>" class="details-button">View Details</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
    </div>
</body>
</html>




