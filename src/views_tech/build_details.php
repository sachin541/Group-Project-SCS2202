<?php

require_once '../components/headers/main_header.php'; 
require_once '../classes/database.php'; 
require_once '../classes/build.php';
require_once '../classes/technician.php';

$database = new Database();
$db = $database->getConnection();
$build = new Build($db);
$techobj = new Technician();

if (isset($_POST["build_id"])){
    $buildID = $_POST["build_id"];
}
else if(isset($_SESSION['current_build_tech'])) {
    $buildID = $_SESSION['current_build_tech']; 
    unset($_SESSION['current_build_tech']);
}else{
    echo "error"; 
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
        $buildDescription = $buildDetails['comments']; 
        $amount = $buildDetails['amount'];
        $technicianId = $buildDetails['technician_id'];

        $rejected = $buildDetails['rejected'];
        $rejected_reson = $buildDetails['rejected_reason'];
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


if($rejected){
    require_once '../components/build_timeline_tech/stage3rejected.php';
}
else if ($build_collected_date) {
    require_once '../components/build_timeline_tech/stage5.php';
} else if ($build_completed_date) {
    require_once '../components/build_timeline_tech/stage4.php';
} else if ($build_start_date) {
    require_once '../components/build_timeline_tech/stage3.php';
} else if ($tech_assigned_date) {
    require_once '../components/build_timeline_tech/stage2.php';
} else {
    require_once '../components/build_timeline_tech/stage1.php';
}


// Include components for build stages
// TODO: Add components for different stages of the build process similar to repair timeline

?>
