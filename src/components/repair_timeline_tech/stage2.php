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

        <li style="--accent-color:#080a0d">
            <div class="date"><?php echo "✔️ Technician assigned!"?></div>
            <div style="margin-bottom: 20px;"></div>
            <div style="margin-bottom: 20px;">Technician Name : <?php echo $tech_name?></div>
            <div style="margin-bottom: 20px;">Technician Mobile : <?php echo $tech_mobile?></div>
            <div style="margin-bottom: 20px;">Date : <?php echo $tech_date?></div>
            <div class="descr">A Technician has been assinged to the Job. Please get into contact</div>
            <div class="accept_button">
            <form action="../helpers/repair_handler.php" method="post" class="details-form">
                    <input type="hidden" name="stage2_accept" value="true">
                    <input type="hidden" name="refnumber" value=<?php echo htmlspecialchars($ref_number); ?>>
                    <input type="submit" value="Next stage" class="details-button">
            </form>
            </div>
        </li>
    

        
    </ul>
</div>
</body>
</html>