<?php
require_once '../classes/database.php'; 
require_once '../classes/order.php'; // Adjust this to your actual OrderManager class
require_once '../classes/delivery.php'; 
require_once '../components/headers/main_header.php';
 
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'deliverer' )){
    header('Location: ../views_main/denied.php');
    exit;
}
$database = new Database();
$db = $database->getConnection(); 

$orderManager = new Order($db); // Initialize OrderManager with DB connection
 // Fetch unassigned orders

$deliveryObj = new Delivery($db);

$status = isset($_GET['status']) ? $_GET['status'] : 'Accepted' ; 
$sortBy = isset($_GET["sortBy"]) ? $_GET['sortBy'] : 'DESC' ; 

$unassignedOrders = $orderManager->getUnassignedOrders($sortBy);
$userDeliveries = $deliveryObj->getMyDeliveries($_SESSION['user_id'] , $status);
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
            <div class="form-cont">
            <form action="" get="get">
            <label for="sortBy">Sort By :</label>   
                <select name="sortBy" id="sortBy" class="filter-dropdown">
                        <option value="DESC" <?php echo $sortBy == 'date_asc' ? 'selected' : ''; ?>>Date Ascending</option>
                        <option value="ASC" <?php echo $sortBy == 'date_desc' ? 'selected' : ''; ?>>Date Descending</option>
                        <input type="submit" name="" id="">
                </select>
            </form>
            </div>
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
            <div class="form-cont">
                <form action="" get="get">
                    <label for="status">Status :</label>   
                    <select name="status" id="status">
                        <!-- <option value="">Sort by</option> -->
                        <option value="Accepted" <?php echo $status == 'Accepted' ? 'selected' : ''; ?>>Accepted</option>
                        <option value="Preparing" <?php echo $status == 'Preparing' ? 'selected' : ''; ?>>Preparing</option>
                        <option value="On The Way" <?php echo $status == 'On The Way' ? 'selected' : ''; ?>>On The Way</option>
                        <option value="Completed" <?php echo $status == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        
                    </select>
                <input type="submit">       
                </form>
            </div>
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

</body>
</html>