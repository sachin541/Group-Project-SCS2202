<?php
require_once '../classes/database.php'; 
require_once '../classes/repair.php';

session_start();

$database = new Database();
$db = $database->getConnection();
$repair = new Repair($db);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rq_type']) )
$customer_id = $_SESSION['user_id'];

$contact = $_POST['contact'];
$item_name = $_POST['item_name'];
$repair_description = $_POST['repair_description'];

$result = $repair->createRepair($customer_id, $contact, $item_name, $repair_description);

if ($result) {
    echo "Repair created successfully.";
    header('Location: ../views_customer/repairs.php');
} else {
    echo "Error creating repair.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tech_accept'])){

    $database = new Database();
    $db = $database->getConnection();
    $repair = new Repair($db);

    $technicianId=$_SESSION['user_id']; 
    $repair_id=$_POST['refnumber'];

    
    if (isset($_POST['rejectReason']) && !empty($_POST['rejectReason'])) {
        echo $_POST['rejectReason'] . $repair_id . $_SESSION['user_id'];
        $reason = $_POST['rejectReason'];
        $technicianId = $_SESSION['user_id'];
        $repair->rejectrepair($repair_id, $technicianId, $reason);
    }
    else{
        $repair->assignTechnicianToRepair($repair_id,$technicianId);
    }
        echo "Repair Updated";
        $_SESSION['current_repair_tech'] = $repair_id;
        header('Location: ../views_tech/repair_managment_details.php');
    

}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stage2_accept'])){

    $database = new Database();
    $db = $database->getConnection();
    $repair = new Repair($db);

    $repair_id=$_POST['refnumber'];
    $repair->progress_repair_stage2($repair_id);

    if ($repair) {
        echo "Repair Updated";
        $_SESSION['current_repair_tech'] = $repair_id;
        header('Location: ../views_tech/repair_managment_details.php');
        
    } else {
        echo "Failed to accept";
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stage3_accept'])){

    $database = new Database();
    $db = $database->getConnection();
    $repair = new Repair($db);

    $repair_id=$_POST['refnumber'];
    $repair->progress_repair_stage3($repair_id);

    if ($repair) {
        echo "Repair Updated";
        $_SESSION['current_repair_tech'] = $repair_id;
        header('Location: ../views_tech/repair_managment_details.php');
        
    } else {
        echo "Failed to accept";
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stage4_accept'])){

    $database = new Database();
    $db = $database->getConnection();
    $repair = new Repair($db);

    $amount=$_POST['amount'];
    $repair_id=$_POST['refnumber'];
    $repair->progress_repair_stage4($repair_id,$amount);

    if ($repair) {
        echo "Repair Updated";
        $_SESSION['current_repair_tech'] = $repair_id;
        header('Location: ../views_tech/repair_managment_details.php');
        
    } else {
        echo "Failed to accept";
    }

}

