<!DOCTYPE html>
<html>
<head>
    <?php require_once '../components/headers/main_header.php';?>
    <title>Create New Repair</title>
    <!-- <link rel="stylesheet" type="text/css" href="../../resources/css/repair_form.css"> -->
</head>



<body>
    
    <h1>Create New Repair</h1>
    <form action="../helpers/handle_repair.php" method="post">
        Your Name: <input type="text" name="customer_id" required><br>
        Contact Number: <input type="tel" name="contact" required><br>
        Item Name: <input type="text" name="item_name" required><br>
        Repair Description: <textarea name="repair_description" required></textarea><br>
        <input type="hidden" name="rq_type" value="new_repair_customer"> 
        <input type="submit" value="Submit">
    </form>
</body>
</html>
