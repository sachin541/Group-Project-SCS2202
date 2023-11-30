<?php

require_once '../components/headers/main_header.php'; 
require_once '../classes/database.php'; 
require_once '../classes/repair.php';

$database = new Database();
$db = $database->getConnection();
$repair = new Repair($db);

if (isset($_POST["repair_id"])) {
    
    $repairDetails = $repair->getAllFromRepairById($_POST["repair_id"]);

    
    if ($repairDetails) {
        
        $repairId = $repairDetails['repair_id'];
        $customerId = $repairDetails['customer_id'];
        $customerName = $repairDetails['customer_name'];
        $contact = $repairDetails['contact'];
        //stage 1 
        $addedTimestamp = $repairDetails['added_timestamp'];
        //stage 2 
        $technicianAssignedDate = $repairDetails['technician_assigned_date'];
        //stage 3 
        $repairWipDate = $repairDetails['repair_wip_date'];
        //stage 4 
        $repairCompletedDate = $repairDetails['repair_completed_date'];
        //stage 5
        $itemCollectedDate = $repairDetails['item_collected_date'];

        $itemName = $repairDetails['item_name'];
        $repairDescription = $repairDetails['repair_description'];
        $amount = $repairDetails['amount'];
        $technicianId = $repairDetails['technician_id'];
        
    } else {
        
        echo "No details found for the given repair ID.";
    }
} else {
    
    echo "Repair ID is not provided.";
}

// echo $addedTimestamp; 

if($itemCollectedDate){
    require_once '../components/repair_timeline/stage4.php';
}else if($repairCompletedDate){
    require_once '../components/repair_timeline/stage3.php';
}else if($repairWipDate){
    require_once '../components/repair_timeline/stage2.php';

}else if($technicianAssignedDate){
    require_once '../components/repair_timeline/stage1.php';
}else{
    require_once '../components/repair_timeline/stage1.php';
}

?>

