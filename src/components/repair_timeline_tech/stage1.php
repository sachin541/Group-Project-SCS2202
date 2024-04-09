<?php 
require 'Base.php';


        
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
        
    <h1>Repair Request Progress</h1>
    <ul>
        <?php echoRequestCreated($ref_number, $start_date, $item_name, $repairDescription) ?>

        <li style="--accent-color:grey">
            <div class="date"><?php echo "Technician will be assigned shortly!"?> </div>
            <div class="accept_button">
                <form action="../helpers/repair_handler.php" method="post" class="details-form">
                        <input type="hidden" name="tech_accept" value="true">
                        <input type="hidden" name="refnumber" value=<?php echo htmlspecialchars($ref_number); ?>>
                        <input type="submit" value="Accept" id="acceptbtn" class="details-button">
                </form>
                        
                        <input type="checkbox" id="rejectToggle" style="display:none;" />
                        <label for="rejectToggle" id="rejectTogglebtn" class="details-button reject">Reject</label>

                    <form action="../helpers/repair_handler.php" method="post" class="details-form"> 
                        <div id="rejectReasonSection" style="display:none;">
                            <textarea name="rejectReason" rows="4" placeholder="Please enter the reason for rejection" required></textarea>
                            <div class="reject-box"> 
                                <input type="hidden" name="tech_accept" value="true">
                                <input type="hidden" name="refnumber" value=<?php echo htmlspecialchars($ref_number); ?>>
                                <input type="submit" value="Submit" class="details-button">
                                <button type="button" id="cancelButton" class="details-button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
        </li>
    
        
    </ul>
</div>
</body>
<script>
        document.getElementById('rejectToggle').addEventListener('change', function() {
            document.getElementById('rejectReasonSection').style.display = this.checked ? 'block' : 'none';
            document.getElementById('rejectTogglebtn').style.display = 'none';
            document.getElementById('acceptbtn').style.display = 'none';
            document.getElementById('state').value = 'reject';
        });

        document.getElementById('cancelButton').addEventListener('click', function() {
            document.getElementById('rejectReasonSection').style.display = 'none';
            document.getElementById('rejectToggle').checked = false;
            document.getElementById('rejectTogglebtn').style.display = 'inline';
            document.getElementById('acceptbtn').style.display = 'inline';
            document.getElementById('state').value = 'true'; // Reset to default state value if cancel is clicked
        });
    </script>
</html>