<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Arrivals</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/slider.css">
</head>

<body>
    <div class="slider-outer-container">
        <h2>New-arrivals</h2>
        <div class="inner-container">

            <?php
            include_once '../utils/dbConnect.php';
            $conn = OpenCon();
            // Prepare an retrieve statement from last 2 weeks
            //$sql = "SELECT product_name, image1, price FROM product WHERE added_timestamp >=  DATE_ADD(CURDATE(),INTERVAL -1400 DAY)";
            $sql = "SELECT product_name, image1, price FROM product WHERE id = 4 OR id = 5  OR id=7 OR id =9 OR id=12 OR id=13";
            if ($result = mysqli_query($conn, $sql)) {

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<div class='item-container'>
                                <div class='slider-img-container'>
                                    <img class='img' src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                </div>
                                <div class='info-container'>
                                    <p>" . $row['product_name'] . "</p>
                                     <p>" . $row['price'] . "</p>
                                </div>
                            </div>";
                    }
                }
                CloseCon($conn);
            }
            ?>
        </div>
    </div>
</body>

</html>