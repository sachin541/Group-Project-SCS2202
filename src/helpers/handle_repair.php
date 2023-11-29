<?php
session_start(); // Start the session to access session variables

require_once '../classes/database.php'; 
require_once '../classes/repair.php';

$database = new Database();
$db = $database->getConnection();

$repair = new Repair($db);

// Retrieve customer_id from session
$customer_id = $_SESSION['user_id']; // Ensure this is the correct session variable name

$contact = $_POST['contact'];
$item_name = $_POST['item_name'];
$repair_description = $_POST['repair_description'];

$result = $repair->createRepair($customer_id, $contact, $item_name, $repair_description);

if ($result) {
    echo "Repair created successfully.";
} else {
    echo "Error creating repair.";
}
?>

