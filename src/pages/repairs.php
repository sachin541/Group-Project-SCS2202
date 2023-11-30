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
    <div  style="text-align: center;">
    <h1>Your Repairs</h1>
    </div>
    <ul>
        <?php foreach($repairs as $repair) : ?>
            <div class="repairs-list">
                <ul>
                    <li>
                        <form action="repair_details.php" method="post" class="details-form">
                            <input type="hidden" name="repair_id" value="<?php echo $repair['repair_id']; ?>">
                            <input type="submit" value="Details" class="details-button">
                        </form>
                        Repair ID: <span class="repair-id"><?php echo htmlspecialchars($repair['repair_id']); ?></span>,
                        Item: <span class="item-name"><?php echo htmlspecialchars($repair['item_name']); ?></span>
                        
                    </li>
                </ul>
            </div>
        <?php endforeach; ?>
    </ul>

       


    <div class = "create_repair">
    <a href="create_repair.php">New Repair</a>
    </div>

</body>
</html>
