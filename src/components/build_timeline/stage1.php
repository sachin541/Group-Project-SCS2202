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

            <li style="--accent-color:grey">
                <div class="date"><?php echo "Technician will be assigned shortly!"?> </div>
                
            </li>
            <!-- Additional stages will be added here based on the build process -->
        </ul>
    </div>
</body>
</html>