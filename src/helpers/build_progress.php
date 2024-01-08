<?php
require_once '../classes/build.php';
session_start();

$database = new Database();
$db = $database->getConnection();
$build = new Build($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $buildId = $_POST['refnumber'];

    if (isset($_POST['tech_accept'])) {
        $technicianId = $_SESSION['user_id']; 
        $build->assignTechnicianToBuild($buildId, $technicianId);
        // Redirect or handle response
    }

    if (isset($_POST['start_build'])) {
        $build->startBuild($buildId);
        // Redirect or handle response
    }

    if (isset($_POST['complete_build'])) {
        $build->completeBuild($buildId);
        // Redirect or handle response
    }

    if (isset($_POST['collect_build'])) {
        $build->collectBuild($buildId);
        // Redirect or handle response
    }


    if ($build) {
        echo "Build Updated";
        $_SESSION['current_build_tech'] = $buildId;
        header('Location: ../views_tech/build_managment.php');
        
    } else {
        echo "Failed";
    }

    // Redirect or response handling after each action
}
