<?php
require_once '../classes/database.php'; 
require_once '../classes/order.php'; // Adjust this to your actual OrderManager class
require_once '../components/headers/main_header.php';
$database = new Database();
$db = $database->getConnection(); 

$orderManager = new Order($db); // Initialize OrderManager with DB connection
$unassignedOrders = $orderManager->getUnassignedOrders(); // Fetch unassigned orders
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unassigned Orders</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_deliverer/acceptOrder.css"> <!-- Make sure this path is correct -->
    
</head>
<body>
    

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
            <h1 class="accpeted">Your Orders</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Created At</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php foreach ($unassignedOrders as $row): ?>
                        <tbody>
                            <tr>
                                <td><?= htmlspecialchars($row['order_id']) ?></td>
                                <td><?= htmlspecialchars($row['total']) ?></td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                                <td>
                                    <a href="detailsOrder.php?order_id=<?= $row['order_id'] ?>" class="button-like-link">View Details</a>
                                </td>
                            </tr>
                        </tbody>
                    <?php endforeach; ?>
                </table>
        </div>

        
    </div>

    <!-- Additional content outside the grid can go here -->

</body>
</html>

