<?php
require_once '../classes/database.php';
require_once '../classes/order.php'; // Adjust this to your actual OrderManager class
require_once '../classes/delivery.php';

$database = new Database();
$db = $database->getConnection();

$orderManager = new Order($db); // Initialize OrderManager with DB connection
$unassignedOrders = $orderManager->getUnassignedOrders(); // Fetch unassigned orders

$deliveryObj = new Delivery($db);
$userDeliveries = $deliveryObj->getMyDeliveries($_SESSION['user_id']);

?>

<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" href="/resources/css/css_deliverer/acceptOrder.css">
<!-- Make sure this path is correct -->


<div class="grid-container">
    <!-- First Column: Unassigned Orders -->
    <div class="table-container">
        <h1 class="unassigned">Unassigned Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Details</th>
                </tr>
            </thead>
            <?php foreach ($unassignedOrders as $row): ?>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($row['order_id']) ?></td>
                        <td class="location-cell">
                            <?= htmlspecialchars($row['city']) ?>
                            <span class="location-hover-text">
                                Province: <?= htmlspecialchars($row['province']) ?><br>
                                City: <?= htmlspecialchars($row['city']) ?><br>
                                Address: <?= htmlspecialchars($row['delivery_city_address']) ?>
                            </span>
                        </td>
                        <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
                        <td>
                            <form action="./detailsOrders.php" method="post" class="details-form">
                                <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                <input type="submit" value="View Details" class="button-like-link">
                            </form>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="table-container">
        <h1 class="unassigned">Your Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Created At</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userDeliveries as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['order_id']) ?></td>
                        <td><?= htmlspecialchars($row['total']) ?></td>
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($row['created_at']))) ?></td>
                        <td>
                            <form action="./detailsOrders.php" method="post" class="details-form">
                                <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                <input type="submit" value="View Details" class="button-like-link">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</div>

<!-- Additional content outside the grid can go here -->

<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>