<?php

require_once '../components/headers/main_header.php'; 
require_once '../classes/database.php'; 
require_once '../classes/build.php';
require_once '../classes/technician.php';

$database = new Database();

$db = $database->getConnection();

$build = new Build($db);

$techobj = new Technician();

if (isset($_POST["build_id"])) {
    
    $buildDetails = $build->getAllFromBuildById($_POST["build_id"]);

    if ($buildDetails) {
        //
        $ref_number = $buildDetails['build_id'];

        $customerId = $buildDetails['customer_id']; //not used 
        $customerName = $buildDetails['customer_name']; //not used 

        $customerContact = $buildDetails['contact'];
        //stage 1 
        $start_date = $buildDetails['added_timestamp'];
        //stage 2 
        $tech_date = $buildDetails['technician_assigned_date'];
        //stage 3 
        $build_start_date = $buildDetails['build_start_date'];
        //stage 4 
        $build_completed_date = $buildDetails['build_completed_date'];
        //stage 5
        $payment_done_date = $buildDetails['build_collected_date'];

        $item_name = null; 
        

        $repairDescription = $buildDetails['comments'];
        

        $amount = $buildDetails['amount'];
        $technicianId = $buildDetails['technician_id'];
        
    } else {
        
        echo "No details found for the given build ID.";
    }
} else {
    
    echo "build ID is not provided.";
}

if($tech_date){
    $technicianDetails = $techobj->getTechnicianByStaffId($technicianId); 
    $tech_mobile = $technicianDetails['mobile_no'];
    $tech_name = $technicianDetails['staff_name'];
}

// echo $addedTimestamp; 

if($payment_done_date){
    require_once '../components/build_timeline/stage5.php';
}else if($build_completed_date){
    require_once '../components/build_timeline/stage4.php';
}else if($build_start_date){
    require_once '../components/build_timeline/stage3.php';

}else if($tech_date){
    require_once '../components/build_timeline/stage2.php';
}else{
    require_once '../components/build_timeline/stage1.php';
}

?>