<?php
session_start();

// Check if the user role is set in the session
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    // Display different footers based on the role
    //roles customer,technician,deliverer,manager.staff

    switch ($role) {
        case 'customer':
            include ('footer-customer.php');
            break;
        case 'manager':
            include ('footer-manager.php');
            break;
        case 'staff':
            include ('footer-staff.php');
            break;
        case 'technician':
            include ('footer-technician.php');
            break;
        case 'deliverer':
            include ('footer-deliverer.php');
            break;
        default:
            include ('footer-unreg.php');
    }
} else {
    // If no role is set, show a default header
    include ('footer-unreg.php');
}
