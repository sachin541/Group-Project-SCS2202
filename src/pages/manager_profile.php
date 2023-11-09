<?php
// Initialize the session
session_start();
$manager_id = "";
// Check if the user is already logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "manager") {
    header("location: login.php");
    exit;
} else {
    $manager_id = $_SESSION["id"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/manager_profile.css" type="text/css">
</head>

<body>
    <!-- header -->
    <?php
    include_once '../utils/dbConnect.php';
    $conn = OpenCon();
    // Prepare an retrieve statement
    $sql = "SELECT * FROM manager_details WHERE manager_id = $manager_id";
    if ($result = mysqli_query($conn, $sql)) {

        $row = mysqli_fetch_array($result);

        $name = $row['name'];
        $position = $row['position'];
        $acc_id = $row['manager_id'];
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
                <!-- <p class="rank">Rank: <?php echo $position ?></p> -->
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
                            <img src="../../resources/images/bell-white.png" alt="cart icon" width="17px" height="17px" style="margin-right: 5px;" />
                            Notifications
                        </button></a>

                    <a id="add-emp"><button class="btn">
                            <img src="../../resources/images/staff.png" alt="staff icon" width="20px" height="20px" style="margin-right: 5px;" />
                            Add Employee
                        </button></a>

                    <a href="contact_us.php"><button class="btn">
                            <img src="../../resources/images/contact.png" alt="cart icon" width="20px" height="20px" style="margin-right: 5px;" />
                            Contact
                        </button></a>

                    <a href="stock.php"><button class="btn">
                            <img src="../../resources/images/stock.png" alt="cart icon" width="17px" height="17px" style="margin-right: 5px;" />
                            Stock
                        </button></a>
                </div>
            </div>
            <div class="body-grid-container-2">
                <div class="distribute-box">
                    <h3>Distribute Work</h3>
                </div>
                <div class="my-work-box">
                    <h3>My Work</h3>
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


        <!-- Add Employee modal -->
        <div id="new-emp" class="modal">
            <div class="modal-content">
                <span class="close" id="e-close">&times;</span>
                <!-- Change the logic in edit_profile.php file appropriately -->
                <h3>Add Employee</h3>
                <form action="edit_profile.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="(Ex: Denam Andrew)" id="emp-name" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="(Ex: name@gmail.com)" id="emp-email" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Should be at least 6 characters" id="emp-password" />
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="(Ex: 123/A, XXXX, XXXX)" id="emp-address" />
                    </div>
                    <div class="form-group">
                        <label for="mobile1">Mobile</label>
                        <input type="text" name="mobile" class="form-control" placeholder="(Ex: +94763049683)" id="emp-mobile1" />
                    </div>
                    <div class="form-group">
                        <label for="mobile2">Alternative Mobile</label>
                        <input type="text" name="alt_mobile" class="form-control" placeholder="(Ex: +94763049683)" id="emp-mobile2" />
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" id="emp-dob" />
                    </div>
                    <div class="form-group">
                        <label for="type">Employee Role</label>
                        <select name="type" class="form-control" id="emp-type">
                            <option value="">Select Role</option>
                            <option value="staff">Staff</option>
                            <option value="technician">Technician</option>
                            <option value="deliverer">Delivery Rider</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input name="submit" class="submit-btn" value="Submit" onclick="createStaff()" />
                    </div>
                </form>
            </div>
        </div>


        <!-- footer -->
        <?php include '../components/footer.php' ?>

    </div>

    <script src="../../resources/js/profile.js"></script>
    <script>
        const createStaff = () => {
            let name = document.getElementById(`emp-name`).value;
            let email = document.getElementById(`emp-email`).value;
            let password = document.getElementById(`emp-password`).value;
            let address = document.getElementById(`emp-address`).value;
            let mobile1 = document.getElementById(`emp-mobile1`).value;
            let mobile2 = document.getElementById(`emp-mobile2`).value;
            let dob = document.getElementById(`emp-dob`).value;
            let role = document.getElementById(`emp-type`).value;

            if (name.length === 0 || email.length === 0 || password.length === 0 || address.length === 0 || mobile1.length === 0 || mobile2.length === 0 || dob.length === 0 || role.length === 0) {
                alert("Please enter all the required fields");
            } else if (password.length < 6) {
                alert("Password should be at least 6 characters");
            } else {
                var formData = new FormData();
                formData.append("name", name);
                formData.append("email", email);
                formData.append("password", password);
                formData.append("address", address);
                formData.append("mobile1", mobile1);
                formData.append("mobile2", mobile2);
                formData.append("dob", dob);
                formData.append("role", role);


                var req = getXmlHttpRequestObject();
                if (req) {
                    req.onreadystatechange = function() {
                        if (req.readyState == 4) {
                            if (req.status == 200) {
                                alert(req.responseText);
                            }
                        }
                    };
                    req.open("POST", "../components/create_new_staff.php", true);
                    req.send(formData);
                }
                document.getElementById('new-emp').style.display = 'none';
            }

        }

        function getXmlHttpRequestObject() {
            if (window.XMLHttpRequest) {
                return new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                return new ActiveXObject("Microsoft.XMLHTTP");
            } else {}
        }
    </script>
</body>

</html>