<?php
require_once '../classes/repair.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tech_accept'] == 'true'){

    $database = new Database();
    $db = $database->getConnection();
    $repair = new Repair($db);

    $technicianId=$_SESSION['user_id']; 
    $repair_id=$_POST['refnumber'];
    $repair->assignTechnicianToRepair($repair_id,$technicianId);

    if ($repair) {
        echo "Repair Updated";
        
    } else {
        echo "Failed to accept";
    }



}