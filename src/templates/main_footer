<?php
session_start();

// Check if the user role is set in the session
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    // Display different headers based on the role
    //roles customer,technician,deliverer,manager.staff

    switch ($role) {
        case 'customer':
            include('../components/footers/footer_customer.php');
            break;
        case 'manager':
            include('../components/footers/footer_manager.php');
            break;
        case 'staff':
            include('../components/footers/footer_staff.php');
            break;
        case 'technician':
            include('../components/footers/footer_technician.php');
            break;
        case 'deliverer':
            include('../components/footers/footer_deliverer.php');
            break;
        default:
            include('../components/footers/footer_unreg.php');
    }
} else {
    // If no role is set, show a default header
    include('../components/footers/footer_unreg.php');
}
