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
            <?php echoPaymentMade($build_collected_date)?>

        </ul>
    </div>
</body>
</html>
