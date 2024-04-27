<?php
require_once '../classes/database.php'; 
require_once '../classes/repair.php';

require_once '../components/headers/main_header.php';
if(!isset($_SESSION['role'])){
    header('Location: ../views_main/denied.php');
    exit;
}

$customerId = $_SESSION['user_id']; 

$database = new Database();
$db = $database->getConnection();

$repair = new Repair($db);
$repairs = $repair->getCustomerRepairsByID($customerId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Repairs</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/repair_details.css">
</head>
<body>
    <div class= "main-container">
        <div class="create-repair-section">
            <h1 class="section-heading">Create New Repair</h1>

            <div class="form-errors">
                <?php if (isset($_SESSION['form_errors'])): ?>
                    <?php foreach ($_SESSION['form_errors'] as $field => $message): ?>
                        <p class="error"><?php echo htmlspecialchars($message); ?></p>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['form_errors']); // Clear errors after displaying ?>
                <?php endif; ?>
            </div>


            <form action="../helpers/repair_handler.php" method="post" class="repair-form">
                <div class="form-field">
                    <label for="customer_name" class="form-label">Your Name:</label>
                    <input type="text" id="customer_name" name="customer_name" class="form-input" required>
                </div>

                <div class="form-field">
                    <label for="contact_number" class="form-label">Contact Number:</label>
                    <input type="tel" id="contact_number" name="contact" class="form-input" required>
                </div>

                <div class="form-field">
                    <label for="item_name" class="form-label">Item Name:</label>
                    <input type="text" id="item_name" name="item_name" class="form-input" required>
                </div>

                <div class="form-field">
                    <label for="repair_description" class="form-label">Repair Description:</label>
                    <textarea id="repair_description" name="repair_description" class="form-textarea" required></textarea>
                </div>

                <input type="hidden" name="rq_type" value="new_repair_customer"> 
                <input type="submit" value="Submit" class="submit-button">
            </form>
        </div>

        <div class="list-repair-section">
            <h1 class="section-heading">Your Repairs</h1>
            <ul class="repairs-list">
                <?php foreach ($repairs as $repair) : ?>
                    <li class="repair-item">
                        
                        <span class="repair-id">Repair ID: <?php echo htmlspecialchars($repair['repair_id']); ?></span>
                        <span class="item-name">Item: <?php echo htmlspecialchars($repair['item_name']); ?></span>

                        <form action="repair_details.php" method="post" class="details-form">
                            <input type="hidden" name="repair_id" value="<?php echo $repair['repair_id']; ?>">
                            <input type="submit" value="Details" class="details-button">
                        </form>
                        
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>

