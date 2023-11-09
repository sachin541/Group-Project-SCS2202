<?php
$login_id = $_SESSION["id"];

include_once '../utils/dbConnect.php';
$conn = OpenCon();
// Prepare an retrieve statement
$customer_sql = "SELECT name FROM customer_details WHERE customer_id = $login_id";
$manager_sql = "SELECT name FROM manager_details WHERE manager_id = $login_id";
$staff_sql = "SELECT name FROM staff_details WHERE staff_id = $login_id";
$technician_sql = "SELECT name FROM technician_details WHERE technician_id = $login_id";
$deliverer_sql = "SELECT name FROM deliverer_details WHERE deliverer_id = $login_id";
$header = "";
if ($result = mysqli_query($conn, $manager_sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $name = $row['name'];
        $header = "../pages/manager_profile.php";
    }
}
if ($result = mysqli_query($conn, $customer_sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $name = $row['name'];
        $header = "../pages/customer_profile.php";
    }
}
if ($result = mysqli_query($conn, $staff_sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $name = $row['name'];
        $header = "../pages/staff_profile.php";
    }
}
if ($result = mysqli_query($conn, $technician_sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $name = $row['name'];
        $header = "../pages/technician_profile.php";
    }
}
if ($result = mysqli_query($conn, $deliverer_sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $name = $row['name'];
        $header = "../pages/deliverer_profile.php";
    }
}
// CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../resources/css/headers.css">
</head>

<body>
    <header class="outer-grid-container">
        <div class="logo-container">
            <a href="../pages/home.php"><img src="../../resources/images/logo2.png" alt="logo png" id="logo" height="50px" /></a>
            <p class="name">COMPUTIFY</p>
        </div>
        <div class="container">
            <div id="menu" class="menu">
                <a href="../pages/product_list.php" class="topnav-item">Products</a>
                <a href="../pages/build.php" class="topnav-item">Build</a>
                <a href="../pages/repairs.php" class="topnav-item">Repairs</a>
                <a href="../pages/contact_us.php" class="topnav-item">Contact Us</a>
            </div>
            <div class="reg-content">

                <a href="wishlist.php"><img src="../../resources/images/heart.png" alt="heart png" class="nav-img" /></a>

                <a href="cart.php"><img src="../../resources/images/cart.png" alt="cart png" class="nav-img" /></a>

                <div class="popup-container">
                    <img src="../../resources/images/notifications.png" alt="notifications png" class="nav-img" id="notification-icn" />
                    <div class="popup-menu-1" id="popup-menu-1">
                        <ul>
                            <?php
                            // Generate menu items dynamically using PHP
                            for ($i = 1; $i <= 3; $i++) {
                                echo '<li>
                                    <img src="../../resources/images/bell.png" alt="bell icon" height="13px" width="13px"/>
                                    <a href="#">Notification ' . $i . '</a>
                                </li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="popup-container">
                    <img src="../../resources/images/profile_icon.png" alt="" class="profile-img" id="profile-img" />
                    <div class="popup-menu-2" id="popup-menu-2">
                        <div class="profile-pop" style="display: grid; grid-template-columns: 5fr 5fr; justify-content:center; align-items:center;">
                            <img src="../../resources/images/profile_icon.png" alt="profile icon" width="80px" height="80px" />
                            <?php
                            echo '<a href="' . $header . '" style="color:grey; text-decoration:underline">Profile</a>';
                            ?>
                        </div>
                        <h4 style="text-align: center; color:black;"><?php echo $name ?></h4>
                        <ul>
                            <li><a href="../pages/settings.php">
                                    <img src="../../resources/images/settings.png" alt="profile icon" width="15px" height="15px" style="margin-right: 1rem;" />
                                    Settings
                                </a></li>
                            <li><a href="../pages/help.php">
                                    <img src="../../resources/images/help.png" alt="profile icon" width="15px" height="15px" style="margin-right: 1rem;" />
                                    Help
                                </a></li>
                            <li><a href="../utils/signout.php">
                                    <img src="../../resources/images/signout.png" alt="profile icon" width="15px" height="15px" style="margin-right: 1rem;" />
                                    Sign out
                                </a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <script src="../../resources/js/reg_header.js"></script>
</body>

</html>