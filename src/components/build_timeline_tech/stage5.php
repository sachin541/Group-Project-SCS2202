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
                <div class="date"><?php echo "✔️ Technician assigned!"?></div>
                <div class="title">
                    <div style="margin-bottom: 20px;">Technician Name : <?php echo $tech_name?></div>
                    <div style="margin-bottom: 20px;">Technician Mobile : <?php echo $tech_mobile?></div>
                    <div style="margin-bottom: 20px;">Assignment Date : <?php echo  $tech_assigned_date?></div>
                    <div class="descr">A Technician has been assigned to the job.</div>
                </div>
            
            </li>
            
            <li style="--accent-color:#080a0d">
                <div class="date"><?php echo "✔️ Build started!"?></div>
                <div class="title">
                <div style="margin-bottom: 20px;"></div>
                <div style="margin-bottom: 20px;">Date : <?php echo $build_start_date?></div>
                <div class="descr">Build is in progress.</div>
                </div>
            </li>
            
            <li style="--accent-color:#080a0d">
                <div class="date"><?php echo "✔️ Build completed!"?></div>
                <div class="title">
                <div style="margin-bottom: 20px;"></div>
                <div style="margin-bottom: 20px;">Date : <?php echo $build_completed_date?></div>
                <div class="descr">Build has been completed item is ready for collection.</div>
                </div>
            </li>

        

            <li style="--accent-color:#080a0d">
                    <div class="date"><?php echo "✔️ Payment made!"?></div>
                    <div class="title">
                    <div style="margin-bottom: 20px;"></div>
                    <div style="margin-bottom: 20px;">Date : <?php echo $build_collected_date?></div>
                    <div class="descr">Payment Made! Request completed.</div>
                    </div>
                    
            </li>
            

            

            

          

            

            <!-- Next stages here... -->
        </ul>
    </div>
</body>
</html>
