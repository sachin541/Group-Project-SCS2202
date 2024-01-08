<?php

require_once '../components/headers/main_header.php'; 
require_once '../classes/database.php'; 
require_once '../classes/build.php';
require_once '../classes/technician.php';

$database = new Database();
$db = $database->getConnection();
$build = new Build($db);
$techobj = new Technician();

echo $_POST["build_id"];

if (isset($_POST["build_id"])) {
    if (isset($_SESSION['current_build_tech'])) {
        $buildID = $_SESSION['current_build_tech']; 
        unset($_SESSION['current_build_tech']);
    } else {
        $buildID = $_POST["build_id"]; 
    }

    $buildDetails = $build->getAllFromBuildById($buildID);

    if ($buildDetails) {
        // Extract build details
        $ref_number = $buildDetails['build_id'];
        $customerId = $buildDetails['customer_id'];
        $customerName = $buildDetails['customer_name'];
        $customerContact = $buildDetails['contact'];
        $added_timestamp = $buildDetails['added_timestamp'];
        $tech_assigned_date = $buildDetails['technician_assigned_date'];
        $build_start_date = $buildDetails['build_start_date'];
        $build_completed_date = $buildDetails['build_completed_date'];
        $build_collected_date = $buildDetails['build_collected_date'];
        $components_list_id = $buildDetails['components_list_id'];
        // comments 
        $buildDescription = $buildDetails['comments']; 
        
        $amount = $buildDetails['amount'];
        $technicianId = $buildDetails['technician_id'];

        // Technician details
        if ($technicianId) {
            $technicianDetails = $techobj->getTechnicianByStaffId($technicianId); 
            $tech_name = $technicianDetails['staff_name'];
            $tech_mobile = $technicianDetails['mobile_no'];
        }

        // Render build details
        // TODO: Add HTML and PHP code to display the build details

    } else {
        echo "No details found for the given build ID.";
    }
} else {
    echo "Build ID is not provided.";
}

// echo $addedTimestamp; 

if($build_collected_date){
    require_once '../components/build_timeline/stage5.php';
}else if($build_completed_date){
    require_once '../components/build_timeline/stage4.php';
}else if($build_start_date){
    require_once '../components/build_timeline/stage3.php';

}else if($tech_assigned_date){
    require_once '../components/build_timeline/stage2.php';
}else{
    require_once '../components/build_timeline/stage1.php';
}

?>