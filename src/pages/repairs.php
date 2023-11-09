<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Repairs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../resources/css/repairs_purchase.css">
</head>

<body>
    <!-- header -->
    <?php include '../components/reg_header.php'
    ?>

    <!-- body content -->
    <div class="repair-outer-container">
        <div class="repair-header-container">
            <img class="repair-img" src="../../resources/images/repairs.png" alt="cart icon" />
            <span class="repair-header">Repairs</span>
        </div>
        <div class="repair-body-container">
            <div class="repair-grid-container1">
                <div class="repair-request-box">
                    <h3>New Repair Requests</h3>
                </div>
                <div class="repair-btn-container">
                    <!-- <button class="add-btn"><a href="###">Reject</a></button> -->
                    <button class="remove-btn"><a href="###">Submit</a></button>
                </div>
            </div>
            <div class="repair-grid-container2">
                <div class="current-repairs-box">
                    <h3>Current Repairs Status</h3>
                </div>
                <div class="complains-box">
                    <h3>Make a Complain</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include '../components/footer.php' ?>

</body>

</html>