<?php
session_start(); // Ensure the session is started

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
                // Add more cases as necessary
            }
        }
    }

    // Check if the handler type is for removing an item
    if (isset($_POST['handler_type']) && $_POST['handler_type'] === 'remove_item') {
        // Check and remove the item type from the session
        if (isset($_POST['item_type'])) {
            $itemType = $_POST['item_type'];

            // Map the item type to the session variable name
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
                // Add more cases as necessary
            }
        }
    }

    // Redirect back to the product display page or handle otherwise
    header('Location: ../views_customer/build_Item_selector.php');
    exit;
}

// If the script is accessed without a POST request, handle accordingly
// For example, redirect to a default page or display an error
