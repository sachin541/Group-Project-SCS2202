<?php
    session_start();
    $staff_id = "";

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "staff") {
        header("location: login.php");
        exit;
    } else {
        $staff_id = $_SESSION["id"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_btn"])) {
        include_once '../utils/dbConnect.php';
        $conn = OpenCon();

        $pro_name = mysqli_real_escape_string($conn, $_POST["pro_name"]);
        $pro_description = mysqli_real_escape_string($conn, $_POST["pro_description"]);
        $pro_price = mysqli_real_escape_string($conn, $_POST["pro_price"]);
        $pro_discount = mysqli_real_escape_string($conn, $_POST["pro_discount"]);
        $pro_ratings = mysqli_real_escape_string($conn, $_POST["pro_ratings"]);
        $pro_brand = mysqli_real_escape_string($conn, $_POST["pro_brand"]);
        $pro_version = mysqli_real_escape_string($conn, $_POST["pro_version"]);
        $pro_category = mysqli_real_escape_string($conn, $_POST["pro_category"]);
        $pro_tmstmp = mysqli_real_escape_string($conn, $_POST["pro_tmstmp"]);

        $image1 = $_FILES["image1"]["tmp_name"];
        $image1Content = addslashes(file_get_contents($image1));
        $image2 = $_FILES["image2"]["tmp_name"];
        $image2Content = addslashes(file_get_contents($image2));
        $image3 = $_FILES["image3"]["tmp_name"];
        $image3Content = addslashes(file_get_contents($image3));
        $image4 = $_FILES["image4"]["tmp_name"];
        $image1Content = addslashes(file_get_contents($image4));

        $sql = "INSERT INTO product (product_name, description, price, discount, ratings, brand, version, category, added_timestamp, image1, image2, image3, image4)
            VALUES ('$pro_name', '$pro_description', '$pro_price', '$pro_discount', '$pro_ratings', '$pro_brand', '$pro_version', '$pro_category', '$pro_tmstmp', '$image1Content', '$image2Content', '$image3Content', '$image4Content')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>showMessage("Product added successfully.", false);</script>';
            header("location: staff_profile.php");
            exit;
        } else {
            echo "Error adding product: " . $conn->error;
        }

        CloseCon($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/add_product.css" type="text/css">
</head>
<style>


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
<?php include '../components/reg_header.php' ?>
<body>
        
    

    <div>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="Product name">Product Name</label>
                <input type="text" name="pro_name" class="form-control" id="pro_name" />
            </div>
            
            <div>
                <label for="Description">Description</label>
                <textarea name="pro_description" id="pro_description" class="form-control" rows="4"></textarea>
            </div>

            <div class="test">
                <label for="Price">Price</label>
                <input type="text" name="pro_price" class="form-control" id="pro_price" />
            </div>
            <div class="test">
                <label for="Discount">Discount</label>
                <input type="text" name="pro_discount" class="form-control" id="pro_discount" />
            </div>
            
            <div>
                <label for="Ratings">Rating</label>
                <input type="text" name="pro_ratings" class="form-control" id="pro_ratings" />
            </div>
            
            <div>
                <label for="Brand">Brand</label>
                <input type="text" name="pro_brand" class="form-control" id="pro_brand" />
            </div>
            
            <div>
                <label for="Version">Version</label>
                <input type="text" name="pro_version" class="form-control" id="pro_version" />
            </div>
            
            <div>
                <label for="Category">Category</label>
                <input type="text" name="pro_category" class="form-control" id="pro_category" />
            </div>
            
            <div>
                <label for="Added On">Added On</label>
                <input type="date" name="pro_tmstmp" class="form-control" id="pro_tmstmp" />
            </div>

            <div>
                <label for="image1">Image 1</label>
                <input type="file" name="image1" id="image1" />
            </div>
            <div>
                <label for="image2">Image 2</label>
                <input type="file" name="image2" id="image2" />
            </div>
            <div>
                <label for="image3">Image 3</label>
                <input type="file" name="image3" id="image3" />
            </div>
            <div>
                <label for="image4">Image 4</label>
                <input type="file" name="image4" id="image4" />
            </div>

            <div>
                <input type="submit" name="submit_btn" />
                <button class="btn" id="cancel-btn">Cancel</button>
            </div>

        <!-- footer -->
        

    </div>

    <script src="../../resources/js/add_product.js"></script>
</body>
<?php include '../components/footer.php' ?>
</html>
