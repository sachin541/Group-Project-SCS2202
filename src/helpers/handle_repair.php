<?php
session_start(); // Start the session to access session variables

require_once '../classes/database.php'; 
require_once '../classes/repair.php';

$database = new Database();
$db = $database->getConnection();

$repair = new Repair($db);

// Retrieve customer_id from session
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['rq_type'] == "new_repair_customer" )
$customer_id = $_SESSION['user_id'];

$contact = $_POST['contact'];
$item_name = $_POST['item_name'];
$repair_description = $_POST['repair_description'];

$result = $repair->createRepair($customer_id, $contact, $item_name, $repair_description);

if ($result) {
    echo "Repair created successfully.";
    header('Location: ../pages/repairs.php');
} else {
    echo "Error creating repair.";
}
?>

