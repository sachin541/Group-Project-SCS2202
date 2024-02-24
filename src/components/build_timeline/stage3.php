<?php require_once 'Base.php'; ?>
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
    <?php echoBuildRequestCreated($ref_number, $added_timestamp, $buildDescription)?>
    <?php echoTechnicianAssigned($tech_name, $tech_mobile, $tech_assigned_date)?>
    <li style="--accent-color:grey">
                <div class="date"><?php echo "Build in progress!"?></div>
                <div style="margin-bottom: 20px;"></div>
                <div style="margin-bottom: 20px;">Date : <?php echo $build_start_date?></div>
                <div class="descr">Build is in progress.</div>
                
    </li>

</ul>
</div>
</body>
</html>