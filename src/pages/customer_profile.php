<?php
// Initialize the session
session_start();
$customer_id = "";
// Check if the user is already logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
} else {
    $customer_id = $_SESSION["id"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../resources/css/customer_profile.css">
</head>

<body>
    <?php
    include_once '../utils/dbConnect.php';
    $conn = OpenCon();
    // Prepare an retrieve statement
    $sql = "SELECT * FROM customer_details WHERE customer_id = $customer_id";
    if ($result = mysqli_query($conn, $sql)) {

        $row = mysqli_fetch_array($result);

        $name = $row['name'];
        $rank = $row['rank'];
        $acc_id = $row['customer_id'];
        $address = $row['address'];
        $mobile = $row['mobile_no'];
        $al_mobile = $row['alternative_mobile_no'];
        $dob = $row['date_of_birth'];
    }

    //Cart Count
    $cart_count = "SELECT count(id) AS cart_count FROM cart_items WHERE customer_id = $customer_id";
    if ($result = mysqli_query($conn, $cart_count)) {
        $row = mysqli_fetch_assoc($result);
        $c_count = $row['cart_count'];
    }

    //wishlist Count
    $wishlist_count = "SELECT count(id) AS wishlist_count FROM wishlist_items WHERE customer_id = $customer_id";
    if ($result = mysqli_query($conn, $wishlist_count)) {
        $row = mysqli_fetch_assoc($result);
        $wl_count = $row['wishlist_count'];
    }

    //loyalty points
    $loyalty_points = "SELECT loyalty_points FROM customer_details WHERE customer_id = $customer_id";
    if ($result = mysqli_query($conn, $loyalty_points)) {
        $row = mysqli_fetch_assoc($result);
        $l_points = $row['loyalty_points'];
    }

    CloseCon($conn);
    ?>

    <?php include '../components/reg_header.php' ?>
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
                <!-- <p class="rank">Rank: <?php echo $rank ?></p> -->
                <div class="profile-name">
                    <p class="profile"><?php echo $name ?></p>
                </div>
                <p class="acc-id">Acc ID: <?php echo $acc_id ?></p>
            </div>
        </div>

        <div class="body-container">

            <div class="body-grid-container-1">
                <div>
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
                    <div class="vouchers">
                        <h3>Vouchers Earned</h3>
                    </div>
                </div>
                <div class="customer-button-box">
                    <a href="cart.php"><button class="btn">
                            <img src="../../resources/images/cart-white.png" alt="cart icon" width="20px" height="20px" style="margin-right: 5px;" />
                            My Cart (<?php echo $c_count ?>)</button>
                    </a>
                    <a href="wishlist.php"><button class="btn">
                            <img src="../../resources/images/heart-white.png" alt="cart icon" width="18px" height="18px" style="margin-right: 5px;" />
                            Wish List (<?php echo $wl_count ?>)</button>
                    </a>
                    <a href=""><button class="btn">
                            <img src="../../resources/images/bell-white.png" alt="cart icon" width="20px" height="20px" style="margin-right: 5px;" />
                            Notifications
                        </button>
                    </a>

                    <a href=""><button class="btn">
                            <img src="../../resources/images/reward.png" alt="cart icon" width="22px" height="22px" style="margin-right: 5px;" />
                            Loyalty Points (<?php echo $l_points ?>)
                        </button>
                    </a>

                    <a href=""><button class="btn">
                            <img src="../../resources/images/history.png" alt="cart icon" width="20px" height="20px" style="margin-right: 5px;" />
                            My History
                        </button>
                    </a>

                    <a href=""><button class="btn">
                            <img src="../../resources/images/bill.png" alt="cart icon" width="20px" height="20px" style="margin-right: 5px;" />
                            Bills
                        </button>
                    </a>
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

        <?php include '../components/footer.php' ?>

    </div>

    <script src="../../resources/js/profile.js"></script>
</body>

</html>