<?php
require_once '../classes/database.php'; 
require_once '../classes/order.php';

require_once '../components/headers/main_header.php';

if(!(isset($_SESSION['role'])) || !($_SESSION['role'] != 'manager' || $_SESSION['role'] != 'staff')){
    header('Location: ../views_main/denied.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$inStore = new Order($db);


if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/staff_login.php');
    exit;
}

$paymentType = isset($_GET['paymentType']) ? $_GET['paymentType'] : null;
$paymentStatus = isset($_GET['paymentStatus']) ? $_GET['paymentStatus'] : null;
$deliveryStatus = isset($_GET['deliveryStatus']) ? $_GET['deliveryStatus'] : null;
$filterBy = isset($_GET['filter_by']) ? $_GET['filter_by'] : null;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : null;


// Modify your getAllOrders function to accept these parameters
$orders = $inStore->getAllOrders($filterBy, $sortBy, $paymentType, $paymentStatus, $deliveryStatus);

// echo "Payment Type: " . $paymentType . "<br>";
// echo "Payment Status: " . $paymentStatus . "<br>";
// echo "Delivery Status: " . $deliveryStatus . "<br>";
// echo "Sort By: " . $sortBy . "<br>";

function formatString($str) {
    // Replace underscores with spaces
    $str = str_replace('_', ' ', $str);

    // Capitalize the first letter of each word
    $str = ucwords($str);

    return $str;
}

$pageType = "Delivery"; 
// print_r($orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ...existing head elements... -->
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/OrdersDeliverySub.css" />
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/toggleswitch.css" />
</head>
<body>
    <div class="orders-container">

            <div class="orders-header">
                <a href="./OrdersDeliverySub.php" class="<?php echo $pageType == "Delivery" ? 'active' : ''; ?>">Online Orders</a>
                <a href="./OrdersRetailSub.php" class="<?php echo $pageType == "Retail" ? 'active' : ''; ?>">InStore Orders</a>
            </div>



            <div class="filter-sort-container">
                
                <form action="" method="GET">
                    <!-- Payment Type Dropdown -->
                    <select name="paymentType" class="filter-dropdown">
                        <option value="">Payment Type</option>
                        <option value="pay_on_delivery" <?php echo $paymentType == 'Pay On Delivery' ? 'selected' : ''; ?>>Pay On Delivery</option>
                        <option value="pay_online" <?php echo $paymentType == 'Online' ? 'selected' : ''; ?>>Online</option>
                    </select>

                    <!-- Payment Status Dropdown -->
                    <select name="paymentStatus" class="filter-dropdown">
                        <option value="">Payment Status</option>
                        <option value="Pending" <?php echo $paymentStatus == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Payment Completed" <?php echo $paymentStatus == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>

                    <!-- Delivery Status Dropdown -->
                    <select name="deliveryStatus" class="filter-dropdown">
                        <option value="">Delivery Status</option>
                        <option value="Order Placed" <?php echo $deliveryStatus == 'Order Placed' ? 'selected' : ''; ?>>Order Placed</option>
                        <option value="Accepted" <?php echo $deliveryStatus == 'Accepted' ? 'selected' : ''; ?>>Accepted</option>
                        <option value="Preparing" <?php echo $deliveryStatus == 'Preparing' ? 'selected' : ''; ?>>Preparing</option>
                        <option value="On The Way" <?php echo $deliveryStatus == 'On The Way' ? 'selected' : ''; ?>>On The Way</option>
                        <option value="Completed" <?php echo $deliveryStatus == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        <!-- Add other delivery status options as needed -->
                    </select>

                    <!-- Sort Dropdown -->
                    <!-- Sort Dropdown -->
                    <select name="sortBy" class="filter-dropdown">
                        <option value="">Sort by</option>
                        <option value="date_asc" <?php echo $sortBy == 'date_asc' ? 'selected' : ''; ?>>Date Ascending</option>
                        <option value="date_desc" <?php echo $sortBy == 'date_desc' ? 'selected' : ''; ?>>Date Descending</option>
                        <option value="id_asc" <?php echo $sortBy == 'id_asc' ? 'selected' : ''; ?>>Order ID Ascending</option>
                        <option value="id_desc" <?php echo $sortBy == 'id_desc' ? 'selected' : ''; ?>>Order ID Descending</option>
                        <option value="total_asc" <?php echo $sortBy == 'total_asc' ? 'selected' : ''; ?>>Total Ascending</option>
                        <option value="total_desc" <?php echo $sortBy == 'total_desc' ? 'selected' : ''; ?>>Total Descending</option>
                    </select>


                    <!-- Submit Button -->
                    <button class="apply-filter-button">Apply Filter</button>
                </form>
            
            </div>
            <?php if (empty($orders)): ?>
            <p class="no-orders-message">No orders found.</p>
            <?php else: ?>



            <table class="orders-table">
                <thead>
                    <tr class="table-header-row">
                        <th class="header-order-id">Order ID</th>
                        
                        <th class="header-created-at">Created At</th>
                        
                        <th class="header-payment-type">Payment Type</th>
                        <th class="header-payment-status">Payment Status</th>
                        <th class="header-total">Total (RS.)</th>
                        <th class="header-total">Delivery Status</th>
                        <th class="header-customer">Customer</th>
                        <th class="header-details">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="table-data-row">
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            
                            <td><?php echo date('Y-m-d', strtotime($order['created_at'])); ?></td>

                            <td><?php echo htmlspecialchars(formatString($order['payment_type'])); ?></td>

                            <td><?php 
                            
                            $status = $order['payment_status']; 

                            if ($status === "Payment Completed") {
                                $status = "Completed";
                            }
                            echo htmlspecialchars(formatString($status)); 

                            ?></td>
                            <td><?php echo htmlspecialchars($order['total']); ?></td>

                            <td><?php echo htmlspecialchars(formatString($order['delivery_status'])); ?></td>
                            
                            <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                            <td>
                                <a href="./OrderDeliveryDetails.php?order_id=<?php echo $order['order_id']; ?>" class="details-button">View Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>



<script>

</script>