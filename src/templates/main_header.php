<?php
session_start();

// Check if the user role is set in the session
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    // Display different headers based on the role
    //roles customer,technician,deliverer,manager.staff

    switch ($role) {
        case 'customer':
            include('../components/headers/header_customer.php');
            break;
        case 'manager':
            include('../components/headers/header_manager.php');
            break;
        case 'staff':
            include('../components/headers/header_staff.php');
            break;
        case 'technician':
            include('../components/headers/header_technician.php');
            break;
        case 'deliverer':
            include('../components/headers/header_deliverer.php');
            break;
        default:
            include('../components/headers/header_unreg.php');
    }
} else {
    // If no role is set, show a default header
    include('../components/headers/header_unreg.php');
}
