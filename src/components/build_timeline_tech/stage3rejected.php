<?php require_once 'Base.php'; ?>
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
        <h1>Build Request Progress</h1>
        <ul>
            <?php echoBuildRequestCreated($ref_number, $added_timestamp, $buildDescription) ?>
            
            <!-- Embed the Build Rejected state directly -->
            <li style="--accent-color:#ff0000"> <!-- Red color to indicate rejection -->
                <div class="date">Build Rejected!</div>
                <div class="title">
                    <div style="margin-bottom: 20px;">Technician Name : <?php echo $tech_name?></div>
                    <div style="margin-bottom: 20px;">Technician Mobile : <?php echo $tech_mobile?></div>
                    <div style="margin-bottom: 20px;">Date : <?php echo htmlspecialchars($tech_assigned_date); ?></div>
                    <div style="word-wrap: break-word;" class="descr">Reason: <?php echo htmlspecialchars($rejected_reson); ?></div>
                </div>
            </li>
            
            <!-- Other states like Build in Progress can be similarly added here -->
            
        </ul>
    </div>
</body>
</html>
