<?php
session_start(); // Ensure the session is started
require_once '../classes/build.php';
require_once '../classes/database.php';

$database = new Database();
$db = $database->getConnection();
$buildobj = new Build($db);

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views_main/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['handler_type']) && $_POST['handler_type'] === 'set_item') {
        // Check and set the item type in the session
        if (isset($_POST['product_id']) && isset($_POST['category'])) {
            $productId = intval($_POST['product_id']);
            $category = $_POST['category'];

            // Map the category to the session variable name
            switch ($category) {
                case 'CPU':
                    $_SESSION['CPU'] = $productId;
                    break;
                case 'GPU':
                    $_SESSION['GPU'] = $productId;
                    break;
                case 'MotherBoard':
                    $_SESSION['MotherBoard'] = $productId;
                    break;
                case 'Memory':
                    $_SESSION['Memory'] = $productId;
                    break;
                case 'Storage':
                    $_SESSION['Storage'] = $productId;
                    break;
                case 'PowerSupply':
                    $_SESSION['PowerSupply'] = $productId;
                    break;
                case 'Case':
                    $_SESSION['Case'] = $productId;
                    break;
                case 'CPU Coolers':
                    $_SESSION['CPU Coolers'] = $productId;
                    break;
                case 'Monitor': // Corrected from "Monitors" to "Monitor"
                    $_SESSION['Monitor'] = $productId;
                    break;
                case 'Mouse':
                    $_SESSION['Mouse'] = $productId;
                    break;
                 case 'Keyboard':
                    $_SESSION['Keyboard'] = $productId;
                    break;
                // Add more cases as necessary
            }
        }
    }

    
    if (isset($_POST['handler_type']) && $_POST['handler_type'] === 'remove_item') {
        
        if (isset($_POST['item_type'])) {
            $itemType = $_POST['item_type'];

           
            switch ($itemType) {
                case 'CPU':
                    unset($_SESSION['CPU']);
                    break;
                case 'GPU':
                    unset($_SESSION['GPU']);
                    break;
                case 'MotherBoard':
                    unset($_SESSION['MotherBoard']);
                    break;
                case 'Memory':
                    unset($_SESSION['Memory']);
                    break;
                case 'Storage':
                    unset($_SESSION['Storage']);
                    break;
                case 'PowerSupply':
                    unset($_SESSION['PowerSupply']);
                    break;
                case 'Case':
                    unset($_SESSION['Case']);
                    break;
                case 'CPU Coolers':
                    unset($_SESSION['CPU Coolers']);
                    break;
                case 'Monitor': // Corrected from "Monitors" to "Monitor"
                    unset($_SESSION['Monitor']);
                    break;
                case 'Mouse':
                    unset($_SESSION['Mouse']);
                    break;
                case 'Keyboard':
                    unset($_SESSION['Keyboard']);
                    break;
                
            }
        }
    }

   
    if (isset($_POST['handler_type']) && $_POST['handler_type'] === 'create_new_build') {

        $requiredComponents = ['CPU', 'GPU', 'MotherBoard', 'CPU Coolers' , 'Memory', 'Storage', 'PowerSupply', 'Case'];
        $missingComponents = [];
    
        // Check each required component is selected
        foreach ($requiredComponents as $component) {
            if (empty($_SESSION[$component])) {
                $missingComponents[] = $component;
            }
        }
    
        // If there are missing components, set an error message
        if (!empty($missingComponents)) {
            $_SESSION['error'] = "Missing required components: " . implode(", ", $missingComponents);
            header('Location: ../views_customer/build_create.php');
            exit;
        }

        $customer_id= $_SESSION['user_id']; 
        $customerName = $_POST['customer_name'];
        $contactNumber = $_POST['contact_number'];
        $additionalNotes = $_POST['additional_notes'];
        $totalPrice = $_POST['build_total'];

        $cpuId = $_SESSION['CPU'];
        $gpuId = $_SESSION['GPU'];
        $motherboardId = $_SESSION['MotherBoard'];
        $memoryId = $_SESSION['Memory'];
        $storageId = $_SESSION['Storage'];
        $powerSupplyId = $_SESSION['PowerSupply'];
        $caseId = $_SESSION['Case'];
        $cpuCoolerId = isset($_SESSION['CPU Coolers']) ? $_SESSION['CPU Coolers'] : null;
        $monitorId = isset($_SESSION['Monitor']) ? $_SESSION['Monitor'] : null; // Corrected
        $mouseId = isset($_SESSION['Mouse']) ? $_SESSION['Mouse'] : null;
        $keyboardId = isset($_SESSION['Keyboard']) ? $_SESSION['Keyboard'] : null;

        $buildobj->createBuild($customer_id, $customerName, $contactNumber, $additionalNotes, 
        $totalPrice, $cpuId, $gpuId, $motherboardId, $memoryId, $storageId, 
        $powerSupplyId, $caseId, $cpuCoolerId, $monitorId, $mouseId, $keyboardId);


        foreach ($_SESSION as $key => $value) {
            if (in_array($key, ['CPU', 'GPU', 'MotherBoard', 'Memory', 'Storage', 'PowerSupply', 'Case', 'CPU Coolers', 'Monitor', 'Mouse', 'Keyboard'])) {
                unset($_SESSION[$key]);
            }
        }
        
    }
    

    
    header('Location: ../views_customer/build_Item_selector.php');
    exit;
}


