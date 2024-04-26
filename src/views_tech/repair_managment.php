<?php
require_once '../classes/database.php'; 
require_once '../classes/repair.php';

require_once '../components/headers/main_header.php';

if($_SESSION['role'] != 'technician'){
    header('Location: ../views_main/denied.php');
    exit;
}
$database = new Database();
$db = $database->getConnection();
$repairobj = new Repair($db);

$technicianId = $_SESSION['user_id'];


$repairFilter = isset($_GET['repair_filter']) ? $_GET['repair_filter'] : 'active';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';



$allrepairs = $repairobj->getAllNewRepairs($sort);
$myrepairs = $repairobj->getTechnicianRepairsbyID($technicianId, $repairFilter); // Modified to include filter
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Repairs</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_tech/repair_management.css">
</head>

<body>
    <!-- <h1>All Repairs</h1> -->

    <!-- Flex Container for Two Columns -->
    <div class="flex-container">

        <!-- New Requests Section -->
        <div class="table-container column">
            <h2>Repair Requests
            <form action="" method="get" class="filter-form">
                <select name="sort">
                    <option value="ASC" <?php echo ($sort == 'ASC') ? 'selected' : ''; ?>>Ascending</option>
                    <option value="DESC" <?php echo ($sort == 'DESC') ? 'selected' : ''; ?>>Decending</option> 
                </select>
                <input type="submit" value="sort">
            </form></h2>
            <?php if(empty($allrepairs)): ?>
                <p>No new requests!</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Repair ID</th>
                            <th>Item Name</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allrepairs as $repair): ?>
                            <?php $statusData = $repairobj->getRepairStatus($repair); ?>
                            <tr>
                                <td><?= htmlspecialchars($repair['repair_id']) ?></td>
                                <td><?= htmlspecialchars($repair['item_name']) ?></td>
                                <td><?= htmlspecialchars($repair['added_timestamp']) ?></td>
                                <td><span class="status-badge <?= $statusData[1] ?>"><?= $statusData[0] ?></span></td>
                                <td class="details-button-cell">
                                    <form action="repair_managment_details.php" method="post">
                                        <input type="hidden" name="repair_id" value="<?= $repair['repair_id'] ?>">
                                        <input type="submit" value="Details" class="button-like-link">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Your Repairs Section -->
        <div class="table-container column">
            <h2>Your Repairs
                <form action="" method="get" class="filter-form">
                <select name="repair_filter">
                    <option value="all" <?php echo ($repairFilter == 'all') ? 'selected' : ''; ?>>All Repairs</option>
                    <option value="completed" <?php echo ($repairFilter == 'completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="active" <?php echo ($repairFilter == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="rejected" <?php echo ($repairFilter == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                </select>
                <input type="submit" value="Filter">
                </form></h2>

            

            <?php if(empty($myrepairs)): ?>
                <p>No active repairs!</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Repair ID</th>
                            <th>Item Name</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($myrepairs as $repair): ?>
                            <?php $statusData = $repairobj->getRepairStatus($repair); ?>
                            <tr>
                                <td><?= htmlspecialchars($repair['repair_id']) ?></td>
                                <td><?= htmlspecialchars($repair['item_name']) ?></td>
                                <td><span class="status-badge <?= $statusData[1] ?>"><?= $statusData[0] ?></span></td>
                                <td class="details-button-cell">
                                    <form action="repair_managment_details.php" method="post">
                                        <input type="hidden" name="repair_id" value="<?= $repair['repair_id'] ?>">
                                        <input type="submit" value="Details" class="button-like-link">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- Filter Form -->
            

        </div>
    </div>
</body>
</html>



