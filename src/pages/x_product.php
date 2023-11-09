
<?php
// Initialize the session
session_start();
$staff_id = "";
// Check if the user is already logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "staff") {
    header("location: login.php");
    exit;
} else {
    $staff_id = $_SESSION["id"];
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
<style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f7f7;
    margin: 0;
    padding: 40px 0;
}

form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #007BFF;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

@media screen and (max-width: 640px) {
    body {
        padding: 20px 0;
    }
}
</style>

<body>
    <!-- header -->
    <?php
    include_once '../utils/dbConnect.php';
    $conn = OpenCon();
    // Prepare an retrieve statement
    $sql = "SELECT * FROM staff_details WHERE staff_id = $staff_id";
    if ($result = mysqli_query($conn, $sql)) {

        $row = mysqli_fetch_array($result);

        $name = $row['name'];
        $position = $row['position'];
        $acc_id = $row['staff_id'];
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
    <form action="process_form.php" method="post" enctype="multipart/form-data">
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" required><br><br>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br><br>

    <label for="price">Price:</label>
    <input type="number" name="price" required><br><br>

    <label for="discount">Discount:</label>
    <input type="number" name="discount" required><br><br>

    <label for="ratings">Ratings:</label>
    <input type="number" name="ratings" required><br><br>

    <label for="brand">Brand:</label>
    <input type="text" name="brand" required><br><br>

    <label for="version">Version:</label>
    <input type="text" name="version" ><br><br>

    <label for="category">Category:</label>
    <input type="text" name="category" ><br><br>

    <label for="image1">Image 1:</label>
    <input type="file" name="image1"><br><br>

    <label for="image2">Image 2:</label>
    <input type="file" name="image2"><br><br>

    <label for="image3">Image 3:</label>
    <input type="file" name="image3"><br><br>

    <label for="image4">Image 4:</label>
    <input type="file" name="image4"><br><br>

    <input type="submit" value="Submit">
        </div>

        
        <!-- footer -->
        <?php include '../components/footer.php' ?>

    </div>

    <script src="../../resources/js/profile.js"></script>
</body>

</html>