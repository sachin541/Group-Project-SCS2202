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
        <h1>Build Request Progress</h1>
        <ul>
            <li style="--accent-color:#080a0d">
                <div class="date"><?php echo "✔️ Request created!"?></div>
                <div class="title">
                    <div style="margin-bottom: 20px;">REF No : <?php echo $ref_number?></div>
                    <div style="margin-bottom: 20px;">Date : <?php echo $start_date?></div>
                    <div style="margin-top: 10px; margin-bottom: 20px;">Item name: <?php echo $item_name; ?></div>
                    <div style= "word-wrap: break-word;" class="descr">Description: <?php echo htmlspecialchars($repairDescription); ?></div>
                </div>
            </li>
            <li style="--accent-color:#29ab4c">
                <div class="date">
                    <?php 
                        if ($tech_assigned_date) {
                            echo "✔️ Technician assigned!";
                        } else {
                            echo "Technician will be assigned shortly!";
                        }
                    ?>
                </div>
            </li>
            <!-- Add more list items based on the repair status. Adjust the visibility and content according to what the customer should see. -->
        </ul>
    </div>
</body>
</html>
