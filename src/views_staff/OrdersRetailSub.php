<?php
require_once '../classes/database.php'; 
require_once '../classes/InStore.php';

require_once '../components/headers/main_header.php';


$database = new Database();
$db = $database->getConnection();
$inStore = new InStore($db);


if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/staff_login.php');
    exit;
}

// Retrieve GET parameters
$filterBy = isset($_GET['filter_by']) ? $_GET['filter_by'] : null;
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : null;

// Modify your getAllOrders function to accept these parameters
$orders = $inStore->getAllOrders($filterBy, $sortBy);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ...existing head elements... -->
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/ViewAllOrders.css" />
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_staff/toggleswitch.css" />
</head>
<body>
    <div class="orders-container">
            <h1 class="orders-header">
                <span style="padding-right: 20px;">Retail Orders</span>
                <label class="switch">
                    <input type="checkbox" id="pageToggle">
                    <span class="slider round"></span>
                </label>
            </h1>

        <?php if (empty($orders)): ?>
            <p class="no-orders-message">No orders found.</p>
        <?php else: ?>
            <div class="filter-sort-container">
                <form action="" method="GET">
                    <!-- Filter Dropdown -->
                    <!-- Filter Dropdown -->
                    <select name="filter_by" onchange="this.form.submit()" class="filter-dropdown">
                        <option value="">Filter by</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <!-- Add other filter options as needed -->
                    </select>

                    <!-- Sort Dropdown -->
                    <select name="sort_by" onchange="this.form.submit()" class="filter-dropdown">
                        <option value="">Sort by</option>
                        <option value="date_asc">Date Ascending</option>
                        <option value="date_desc">Date Descending</option>
                        <option value="total_asc">Total Ascending</option>
                        <option value="total_desc">Total Descending</option>
                        <!-- Add other sorting options as needed -->
                    </select>

                </form>
            </div>



            <table class="orders-table">
                <thead>
                    <tr class="table-header-row">
                        <th class="header-order-id">Order ID</th>
                        <th class="header-total">Total (RS.)</th>
                        <th class="header-created-at">Created At</th>
                        <!-- <th class="header-created-by">Created By</th> -->
                        <th class="header-payment-type">Payment Type</th>
                        <th class="header-payment-status">Payment Status</th>
                        <th class="header-customer">Customer</th>
                        <th class="header-details">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="table-data-row">
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['total']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($order['created_at'])); ?></td>

                            <!-- <td><?php echo htmlspecialchars($order['createdby']); ?></td> -->
                            <td><?php echo htmlspecialchars($order['payment_type']); ?></td>
                            <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
                            <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                            <td>
                                <a href="./OrderRetailDetails.php?order_id=<?php echo $order['order_id']; ?>" class="details-button">View Details</a>
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
    // Function to change page based on toggle state
    function changePage() {
        window.location.href = document.getElementById('pageToggle').checked ? 'OrdersDeliverySub.php' : 'OrdersRetailSub.php';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Set the toggle state based on local storage value
        var savedState = localStorage.getItem('toggleState') === 'true';
        document.getElementById('pageToggle').checked = savedState;

        // Add event listener to the toggle
        document.getElementById('pageToggle').addEventListener('change', function() {
            // Save the new state to local storage
            localStorage.setItem('toggleState', this.checked);
            // Change page
            changePage();
        });
    });
</script>

