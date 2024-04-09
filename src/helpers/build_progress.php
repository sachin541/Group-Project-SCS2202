<?php
require_once '../classes/build.php';
session_start();

$database = new Database();
$db = $database->getConnection();
$build = new Build($db);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $buildId = $_POST['refnumber'];
    $_SESSION['current_build_tech'] = $buildId;

    if (isset($_POST['rejectReason']) && !empty($_POST['rejectReason'])) {
        echo $_POST['rejectReason'] . $buildId . $_SESSION['user_id'];
        $reason = $_POST['rejectReason'];
        $technicianId = $_SESSION['user_id'];
        $build->rejectBuild($buildId, $technicianId, $reason);
    } elseif(isset($_POST['tech_accept']) && $_POST['tech_accept'] == 'true') {
        $buildId = $_POST['refnumber'];
        $outOfStockItems = $build->checkComponentStock($buildId);
    
        if (!empty($outOfStockItems)) {
            // Items are out of stock, set session variable and redirect
            $_SESSION['error'] = "The following items are out of stock: " . implode(", ", $outOfStockItems);
            header('Location: ../views_tech/build_details.php');
            exit;
        } else {
            // Proceed with technician assignment
            unset($_SESSION['error']);
            $build->reduceComponentStock($buildId);
            $technicianId = $_SESSION['user_id'];
            $build->assignTechnicianToBuild($buildId, $technicianId);
            // Other processing and redirection
        }
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

    
    
    header('Location: ../views_tech/build_details.php');
    
    // Redirect or response handling after each action
}
