<!DOCTYPE html>
<html lang="en">

<head>
    <title>Content</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/content.css" type="text/css">
</head>

<body>
    <div class="item-list">

        <?php

        if (isset($_GET['id'])) {
            $buttonId = $_GET['id'];

            switch ($buttonId) {
                case "laptop":

                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT id, product_name, image1, description, price FROM product WHERE category = 'Laptop'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item-card' onclick='clickItem(" . $row['id'] . ")'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <p class='price'>" . $row['price'] . "</p>
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }

                    break;
                case "acc":

                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT product_name, image1, description, price FROM product WHERE category = 'Accessories'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item-card'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <p class='price'>" . $row['price'] . "</p>
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }
                    break;
                case "gaming":

                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT product_name, image1, description, price FROM product WHERE category = 'Gaming Desktop'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item-card'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <p class='price'>" . $row['price'] . "</p>
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }
                    break;
                case "desktop":

                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT product_name, image1, description, price FROM product WHERE category = 'Desktop'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item-card'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <p class='price'>" . $row['price'] . "</p>
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }
                    break;
                case "console":

                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT product_name, image1, description, price FROM product WHERE category = 'Console'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item-card'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <p class='price'>" . $row['price'] . "</p>
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }
                    break;
                case "apple":

                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT product_name, image1, description, price FROM product WHERE category = 'Apple'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item-card'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <p class='price'>" . $row['price'] . "</p>
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }
                    break;
                case "rog":

                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT product_name, image1, description, price FROM product WHERE category = 'ASUS ROG'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item-card'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <p class='price'>" . $row['price'] . "</p>
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }
                    break;
                case "cs-asus":

                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT product_name, image1, description, price FROM product WHERE category = 'CS ASUS'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item-card'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <p class='price'>" . $row['price'] . "</p>
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }
                    break;
                case "p-asus":

                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT product_name, image1, description, price FROM product WHERE category = 'Powered ASUS'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item-card'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <p class='price'>" . $row['price'] . "</p>
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }
                    break;
                default:
                    echo "<script>alert('Invalid ID');</script>";
            }
        } else {
            echo "No button ID specified.";
        }
        ?>
    </div>
</body>

</html>