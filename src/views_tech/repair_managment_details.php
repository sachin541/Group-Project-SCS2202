<?php

require_once '../components/headers/main_header.php'; 
require_once '../classes/database.php'; 
require_once '../classes/repair.php';
require_once '../classes/technician.php';

$database = new Database();
$db = $database->getConnection();
$repair = new Repair($db);
$techobj = new Technician();

if (isset($_POST["repair_id"])|| $_SESSION['current_repair_tech']) {
    if (isset($_SESSION['current_repair_tech'])) {
        $repairID = $_SESSION['current_repair_tech']; 
        unset($_SESSION['current_repair_tech']);
        
    }else{
        $repairID = $_POST["repair_id"]; 
    }

    
    $repairDetails = $repair->getAllFromRepairById($repairID);



    
    
    if ($repairDetails) {
        //
        $ref_number = $repairDetails['repair_id'];

        $customerId = $repairDetails['customer_id']; //not used 
        $customerName = $repairDetails['customer_name']; //not used 

        $customerContact = $repairDetails['contact'];
        //stage 1 
        $start_date = $repairDetails['added_timestamp'];
        //stage 2 
        $tech_date = $repairDetails['technician_assigned_date'];
        //stage 3 
        $repair_start_date = $repairDetails['repair_wip_date'];
        //stage 4 
        $repair_completed_date = $repairDetails['repair_completed_date'];
        //stage 5
        $payment_done_date = $repairDetails['item_collected_date'];

        $item_name = $repairDetails['item_name'];
        $repairDescription = $repairDetails['repair_description'];
        $amount = $repairDetails['amount'];
        $technicianId = $repairDetails['technician_id'];
        
        $rejected = $repairDetails['rejected'];
        $rejected_reson = $repairDetails['rejected_reason'];

    } else {
        
        echo "No details found for the given repair ID.";
    }
} else {
    
    echo "Repair ID is not provided.";
}

// echo $addedTimestamp; 

if($tech_date){
    $technicianDetails = $techobj->getTechnicianByStaffId($technicianId); 
    
    $tech_mobile = $technicianDetails['mobile_no'];
    $tech_name = $technicianDetails['staff_name'];
}

if($rejected){
    require_once '../components/repair_timeline_tech/stage3rejected.php';
}
else if($payment_done_date){
    require_once '../components/repair_timeline_tech/stage5.php';
}else if($repair_completed_date){
    require_once '../components/repair_timeline_tech/stage4.php';
}else if($repair_start_date){
    require_once '../components/repair_timeline_tech/stage3.php';

}else if($tech_date){
    require_once '../components/repair_timeline_tech/stage2.php';
}else{
    require_once '../components/repair_timeline_tech/stage1.php';
}

?>