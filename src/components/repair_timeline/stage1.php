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
    <link rel="stylesheet" type="text/css" href="../../resources/css/headers.css">
    
</head>


<body>
    
<div>
    <h1>Repair Request Progress</h1>
    <ul>
        <?php echoRequestCreated($ref_number, $start_date, $item_name, $repairDescription) ?>

        <li style="--accent-color:grey">
            <div class="date"><?php echo "Technician will be assigned shortly!"?></div>
        </li>

    </ul>
</div>
</body>
</html>