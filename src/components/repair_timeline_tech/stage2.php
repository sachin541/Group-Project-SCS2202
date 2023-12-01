<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href="../../resources/css/timeline_tech.css">
    
    
</head>
<body>
    

    




    <div>
    <h1>Repair Request Progress</h1>
<ul>
    <li style="--accent-color:#080a0d">
        <div class="date"><?php echo "✔️ Request created!"?></div>
        <div class="title">
          <div style="margin-bottom: 20px;">REF No : <?php echo $ref_number?></div>
          <div style="margin-bottom: 20px;">Date : <?php echo $start_date?></div>

          <div style="margin-top: 10px; margin-bottom: 20px;">Item name: <?php echo $item_name; ?></div>
          
          <div style= "word-wrap: break-word;" class="descr">Description: <?php echo htmlspecialchars($repairDescription); ?></div>

    </li>
    <li style="--accent-color:#080a0d">
        <div class="date"><?php echo "✔️ Technician assigned!"?></div>
        <div style="margin-bottom: 20px;"></div>
        <div style="margin-bottom: 20px;">Technician Name : <?php echo $tech_name?></div>
        <div style="margin-bottom: 20px;">Technician Mobile : <?php echo $tech_mobile?></div>
        <div style="margin-bottom: 20px;">Date : <?php echo $tech_date?></div>
        <div class="descr">A Technician has been assinged to the Job. Please get into contact</div>
    </li>
    </li>
    <li style="--accent-color:#29ab4c">
        <div class="date"><?php echo "Repair in progress!"?></div>
        <div style="margin-bottom: 20px;"></div>
        <div style="margin-bottom: 20px;">Date : <?php echo $repair_start_date?></div>
        <div class="descr">Repair is in progress.</div>
    </li>
    <!-- <li style="--accent-color:#080a0d">
        <div class="date"><?php echo "✔️ Repair completed"?></div>
        <div style="margin-bottom: 20px;"></div>
        <div style="margin-bottom: 20px;">Date : <?php echo $repair_completed_date?></div>
        <div class="descr">Repair has been completed item is read for collection.</div>
    </li> -->
    <!-- <li style="--accent-color:#080a0d">
        <div class="date"><?php echo "✔️ Payment made!"?></div>
        <div style="margin-bottom: 20px;"></div>
        <div style="margin-bottom: 20px;">Date : <?php echo $payment_done_date?></div>
        <div class="descr">Payment Made! Request completed.</div>
        
    </li> -->
    
</ul>
    </div>
</body>
</html>