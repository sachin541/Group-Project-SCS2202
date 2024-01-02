<?php
require_once '../classes/database.php'; 
require_once '../classes/repair.php';

require_once '../components/headers/main_header.php';

// Assume customer ID is stored in session or retrieved through some mechanism
$technicianId = $_SESSION['user_id']; 

$database = new Database();
$db = $database->getConnection();

$repair = new Repair($db);
$allrepairs = $repair->getAllNewRepairs();
$myrepairs = $repair->getTechnicianRepairsbyID($technicianId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Repairs</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_tech/repair_managment.css">
    
</head>
<body>
<div class="req-container">
    <div class="req-contain">
    <div  style="text-align: center;">
        <h1>New Requets</h1>
    </div>

    <ul>
        <?php foreach($allrepairs as $repair) : ?>
            <div class="repairs-list">
                <ul>
                    <li>
                        <form action="repair_managment_details.php" method="post" class="details-form">
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
    
    </div>

    <div class="req-contain">
    <div  style="text-align: center;">
        <h1>Your Repairs</h1>
    </div>

    <ul>
        <?php if(empty(($myrepairs))){
            echo '<div class="repairs-list">
            <ul>
                <li>
                    
                    No active repairs!
                    
                </li>
            </ul>
        </div>';
            }?>
        <?php foreach($myrepairs as $repair) : ?>
            <div class="repairs-list">
                <ul>
                    <li>
                        <form action="repair_managment_details.php" method="post" class="details-form">
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
    
    </div>
</div>

 </body>