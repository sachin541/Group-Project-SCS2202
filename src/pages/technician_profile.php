<?php
// Initialize the session
session_start();
$technician = "";
// Check if the user is already logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "technician") {
    header("location: login.php");
    exit;
} else {
    $technician = $_SESSION["id"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/staff_profile.css" type="text/css">
</head>

<body>
    <!-- header -->
    <?php
    include_once '../utils/dbConnect.php';
    $conn = OpenCon();
    // Prepare an retrieve statements
    $sql = "SELECT * FROM technician_details WHERE technician_id = $technician";
    if ($result = mysqli_query($conn, $sql)) {

        $row = mysqli_fetch_array($result);

        $name = $row['name'];
        $position = $row['position'];
        $acc_id = $row['technician_id'];
        $address = $row['address'];
        $mobile = $row['mobile_no'];
        $al_mobile = $row['alternative_mobile_no'];
        $dob = $row['date_of_birth'];
    }
    CloseCon($conn);
    ?>

    <?php include '../components/reg_header.php' ?>

    <!-- body content -->
    <div class="main-container">
        <!-- profile info grid -->
        <div class="profile-grid">
            <div class="img-outer-container">
                <div class="img-container">
                    <img src="../../resources/images/profile_icon.png" alt="profile icon" width="300px" height="300px" />
                </div>
                <a class="change-pic" href="change_pic.php">Change profile picture</a>
            </div>
            <div class="detail-container">
                <p class="rank">Position: <?php echo $position ?></p>
                <div class="profile-name">
                    <p class="profile"><?php echo $name ?></p>
                </div>
                <p class="acc-id">Acc ID: <?php echo $acc_id ?></p>
            </div>
        </div>

        <!-- body -->
        <div class="body-container">
            <div class="body-grid-container-1">
                <div class="details-box">
                    <div>
                        <h3>Name : <?php echo $name ?></h3>
                        <h3>Address : <?php echo $address ?></h3>
                        <h3>Mobile No. : <?php echo $mobile ?></h3>
                        <h3>Alternative mobile No. : <?php echo $al_mobile ?></h3>
                        <h3>Date of birth : <?php echo $dob ?></h3>
                        <button class="edit-btn" id="edit">Edit Profile</button>
                    </div>
                </div>
                <div class="manager-button-box">
                    <a href=""><button class="btn">
                            <img src="../../resources/images/bell-white.png" alt="notification icon" width="17px" height="17px" style="margin-right: 5px;" />
                            Notifications
                        </button></a>

                    <a href="stock.php"><button class="btn">
                            <img src="../../resources/images/stock.png" alt="stock icon" width="20px" height="20px" style="margin-right: 5px;" />
                            Repair Requests
                        </button></a>

                    <a href="physical_store.php"><button class="btn">
                            <img src="../../resources/images/shop.png" alt="store icon" width="17px" height="17px" style="margin-right: 5px;" />
                            Request tools
                        </button></a>

                    <a href=""><button class="btn">
                            <img src="../../resources/images/manager.png" alt="cart icon" width="17px" height="17px" style="margin-right: 5px;" />
                            Contact Manager
                        </button></a>
                </div>
            </div>
            <div class="body-grid-container-2">
                <div class="duties-box">
                    <h3>Assigned Duties</h3>
                </div>
                <div class="schedule-box">
                    <h3>Duty Schedule</h3>
                </div>
            </div>
        </div>

        <!-- Edit profile modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" id="close">&times;</span>
                <!-- Change the logic in edit_profile.php file appropriately -->
                <h3>Edit Profile</h3>
                <form action="edit_profile.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="(Ex: Denam Andrew)" id="name" />
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="(Ex: 123/A, XXXX, XXXX)" id="address" />
                    </div>
                    <div class="form-group">
                        <label for="mobile1">Mobile</label>
                        <input type="text" name="mobile" class="form-control" placeholder="(Ex: +94763049683)" id="mobile1" />
                    </div>
                    <div class="form-group">
                        <label for="mobile2">Alternative Mobile</label>
                        <input type="text" name="alt_mobile" class="form-control" placeholder="(Ex: +94763049683)" id="mobile2" />
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" id="dob" />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="submit-btn" />
                    </div>
                </form>
            </div>
        </div>

        <!-- footer -->
        <?php include '../components/footer.php' ?>

    </div>

    <script src="../../resources/js/profile.js"></script>
</body>

</html>