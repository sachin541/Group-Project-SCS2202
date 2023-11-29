<?php
require_once '../classes/database.php'; 
require_once '../classes/repair.php';

require_once '../components/headers/main_header.php';

// Assume customer ID is stored in session or retrieved through some mechanism
$customerId = $_SESSION['user_id']; 

$database = new Database();
$db = $database->getConnection();

$repair = new Repair($db);
$repairs = $repair->getCustomerRepairsByID($customerId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Repairs</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/repair_detailsnew.css">
    
</head>
<body>
    <h1>Your Repairs</h1>
    <ul>
        <?php foreach($repairs as $repair) : ?>
            <li>
                Repair ID: <?php echo htmlspecialchars($repair['repair_id']); ?>, 
                Item: <?php echo htmlspecialchars($repair['item_name']); ?>
                <a href="repair_details.php?id=<?php echo $repair['repair_id']; ?>">Details</a>
            </li>
        <?php endforeach; ?>
    </ul>
        <div class = "create_repair">
    <a href="create_repair.php">New Repair</a>
        </div>
</body>
</html>
