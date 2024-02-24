<?php 
require 'Base.php';      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_components/timeline_tech.css">
    
    
</head>
<body>

<div>
    <h1>Repair Request Progress</h1>
    <ul>
        <?php echoRequestCreated($ref_number, $start_date, $item_name, $repairDescription) ?>
        
        <?php echoTechnicianAssigned($tech_name, $tech_mobile, $tech_date) ?>
        
        <?php echoRepairCompleted($repair_start_date, $repair_completed_date) ?>

        <li style="--accent-color:grey">
            <div class="date"><?php echo "Payment and collection pending!"?></div>
            <div style="margin-bottom: 20px;"></div>
            <div class="accept_button">
            <form action="../helpers/repair_handler.php" method="post" class="details-form">
                    <input type="hidden" name="stage4_accept" value="true">
                    <input type="hidden" name="refnumber" value=<?php echo htmlspecialchars($ref_number); ?>>
                    <input type="submit" value="Complete" class="details-button">
            </form>
            </div>
             
        </li>
        
    </ul>
 </div>
</body>
</html>