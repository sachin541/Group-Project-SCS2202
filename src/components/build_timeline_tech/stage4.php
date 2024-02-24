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
            <?php echoBuildRequestCreated($ref_number, $added_timestamp, $buildDescription)?>
            <?php echoTechnicianAssigned($tech_name, $tech_mobile, $tech_assigned_date)?>
            <?php echoBuildCompleted($build_start_date, $build_completed_date)?>

            <li style="--accent-color:grey">
                <div class="date"><?php echo "Payment and collection pending!"?></div>
                <div style="margin-bottom: 20px;"></div>
                <div class="accept_button">
                <form action="../helpers/build_progress.php" method="post" class="details-form">
                        <input type="hidden" name="collect_build" value="true">
                        <input type="hidden" name="refnumber" value=<?php echo htmlspecialchars($ref_number); ?>>
                        <input type="submit" value="Complete" class="details-button">
                </form>
                </div>
                
            </li>
            
           
        </ul>
    </div>
</body>
</html>
