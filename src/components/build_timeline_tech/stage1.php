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
            <li style="--accent-color:#080a0d">
                <div class="date"><?php echo "✔️ Build request created!"?></div>
                <div class="title">
                    <div style="margin-bottom: 20px;">REF No : <?php echo $ref_number?></div>
                    <div style="margin-bottom: 20px;">Date : <?php echo $added_timestamp?></div>
                    <div style= "word-wrap: break-word;" class="descr">Comments: <?php echo htmlspecialchars($buildDescription); ?></div>
                </div>
            </li>

            <li style="--accent-color:#080a0d">
                <div class="date"><?php echo "Technician will be assigned shortly!"?> </div>
                <div class="accept_button">
                    <form action="../helpers/build_progress.php" method="post" class="details-form">
                        <input type="hidden" name="tech_accept" value="true">
                        <input type="hidden" name="refnumber" value="<?php echo htmlspecialchars($ref_number); ?>">
                        <input type="submit" value="Accept" class="details-button">
                    </form>
                </div>
            </li>
            <!-- Additional stages will be added here based on the build process -->
        </ul>
    </div>
</body>
</html>
