<?php require_once 'Base.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_components/timeline_tech.css">
    <style>
        #rejectToggle:checked ~ #rejectReasonSection {
            display: block;
        }
    </style>
</head>
<body>
    <div>
        <h1>Build Request Progress</h1>
        <ul>
            <?php echoBuildRequestCreated($ref_number, $added_timestamp, $buildDescription) ?>

            <li style="--accent-color:grey">
                <div class="date"><?php echo "Technician will be assigned shortly!" ?></div>
                <!-- accept button  -->
                <div class="accept_button">
                    <form action="../helpers/build_progress.php" method="post" class="details-form">
                        <input type="hidden" id="state" name="tech_accept" value="true">
                        <input type="hidden" name="refnumber" value="<?php echo htmlspecialchars($ref_number); ?>">
                        <input type="submit" value="Accept" id="acceptbtn" class="details-button">

                        <!-- New Checkbox to trigger the display of the rejection reason -->
                        <input type="checkbox" id="rejectToggle" style="display:none;" />
                        <label for="rejectToggle" id="rejectTogglebtn" class="details-button reject">Reject</label>

                        <!-- Hidden section for rejection reason -->
                        <div id="rejectReasonSection" style="display:none;">
                            <textarea name="rejectReason" rows="4" placeholder="Please enter the reason for rejection"></textarea>
                            <input type="submit" value="Submit Reason" class="details-button">
                        </div>
                    </form>
                </div>
            </li>
            <!-- Additional stages will be added here based on the build process -->
        </ul>
    </div>

    <script>
        document.getElementById('rejectToggle').addEventListener('change', function() {
            document.getElementById('rejectReasonSection').style.display = this.checked ? 'block' : 'none';
            document.getElementById('rejectTogglebtn').style.display = 'none';
            document.getElementById('acceptbtn').style.display = 'none';
            document.getElementById('state').value = 'reject';
        });
        
    </script>
</body>
</html>

