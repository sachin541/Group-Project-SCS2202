<?php 
require_once 'Base.php'; 
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_components/timeline.css">

</head>
<body>
<div>
    <h1>Repair Request Progress</h1>
    <ul>
    
    <?php echoRequestCreated($ref_number, $start_date, $item_name, $repairDescription) ?> 
    <?php echoTechnicianAssigned($tech_name, $tech_mobile, $tech_date) ?> 

    <li style="--accent-color:grey">
        <div class="date"><?php echo "Repair in progress!"?></div>
        <div style="margin-bottom: 20px;"></div>
        <div style="margin-bottom: 20px;">Start Date : <?php echo $repair_start_date?></div>
        <div class="descr">Repair has started. An update will be provided</div>
    </li>
   
    
</ul>
</div>
</body>
</html>