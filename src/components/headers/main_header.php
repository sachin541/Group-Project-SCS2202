<?php
session_start();

// Check if the user role is set in the session
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    // Display different headers based on the role
    //roles customer,technician,deliverer,manager.staff

    switch ($role) {
        case 'customer':
            include('header_customer.php');
            break;
        case 'manager':
            include('header_manager.php');
            break;
        case 'staff':
            include('header_staff.php');
            break;
        case 'technician':
            include('header_technician.php');
            break;
        case 'deliverer':
            include('header_deliverer.php');
                break;
        default:
            include('header_unreg.php');
    }
} else {
    // If no role is set, show a default header
    include('header_unreg.php');
}
