<?php require_once 'Base.php'; 
// $_SESSION['email_error'] = "error"; 
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
        <h1>Build Request Progress</h1>
        <ul>
            <?php echoBuildRequestCreated($ref_number, $added_timestamp, $buildDescription)?>
            <?php echoTechnicianAssigned($tech_name, $tech_mobile, $tech_assigned_date)?>
            
            <li style="--accent-color:grey">
                <div class="date"><?php echo "Build in progress!"?></div>
                <div style="margin-bottom: 20px;"></div>
                <div style="margin-bottom: 20px;">Date : <?php echo $build_start_date?></div>
                <div class="descr">Build is in progress.</div>
                <div class="accept_button">
                
                <div class="notify"> 
                    <?php 
                    if (isset($_SESSION['email_error'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['email_error']) . '</div>';
                        unset($_SESSION['email_error']);
                    }
                    ?>
                    <form action="../helpers/build_progress.php" method="post" class="details-form">
                        <input type="hidden" name="complete_build" value="true">
                        <input type="hidden" name="refnumber" value="<?php echo htmlspecialchars($ref_number); ?>">
                        <label class="custom-checkbox">Notify Customer by Email
                            <input type="checkbox" name="notify_customer" id="notify_customer" value="yes" class="check" checked>
                            <span class="checkmark"></span>
                        </label>
                        <input type="submit" value="Complete Build" class="details-button">
                    </form>
                </div>

                
                </div>
            </li>
            
            <!-- Additional stages will be added here based on the build process -->
        </ul>
    </div>
</body>
</html>
