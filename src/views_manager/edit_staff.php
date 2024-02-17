<?php
require_once '../classes/UserManager.php';
require_once '../classes/database.php';

$database = new Database();
$db = $database->getConnection();
$userManager = new UserManager();

// Retrieve staff ID from GET request
$staff_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($staff_id) {
    // Fetch staff details
    $staffDetails = $userManager->getStaffById($staff_id); // Make sure this function is defined in UserManager class
}
?>

<!-- Template Top -->
<?php require_once '../templates/main_top.php'; ?>

<!-- Stylessheets -->


</head>

<body>

    <!-- Header -->
    <?php require_once '../templates/main_header.php'; ?>

    <?php if ($staffDetails): ?>
        <form action="../helpers/employee_handler.php" method="post">
            <input type="hidden" name="handler_type" value="update_staff">
            <input type="hidden" name="staff_id" value="<?= htmlspecialchars($staffDetails['staff_id']) ?>">


            <input type="text" name="name" value="<?= htmlspecialchars($staffDetails['staff_name']) ?>">
            <input type="text" name="address" value="<?= htmlspecialchars($staffDetails['staff_address']) ?>">
            <input type="text" name="mobile_no" value="<?= htmlspecialchars($staffDetails['mobile_no']) ?>">
            <input type="text" name="alternative_mobile_no"
                value="<?= htmlspecialchars($staffDetails['alternative_mobile_no']) ?>">
            <input type="date" name="date_of_birth" value="<?= htmlspecialchars($staffDetails['date_of_birth']) ?>">
            <input type="number" name="sal" value="<?= htmlspecialchars($staffDetails['sal']) ?>">

            <input type="submit" value="Update Staff">
        </form>
    <?php else: ?>
        <p>Staff not found.</p>
    <?php endif; ?>

    <!-- Footer -->
    <?php require_once '../templates/main_footer.php'; ?>

    <!-- Template Bottom -->
    <?php require_once '../templates/main_bottom.php'; ?>