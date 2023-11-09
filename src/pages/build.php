<?php
// Initialize the session
session_start();
$customer_id = "";
// Check if the user is already logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "customer") {
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
    <title>Build PC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/build.css" type="text/css">
</head>

<body>
    <?php if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        include '../components/unreg_header.php';
    } else {
        include '../components/reg_header.php';
    }
    ?>
    <div class="build-outer-container">
        <div class="build-selector">
            <p>Type of PC you need : </p>
            <select class="select-build">
                <option value="" disabled>Select Build</option>
                <option value="atx">Lenovo Pro 1</option>
                <option value="atx-tower">MSI Pro 2</option>
                <option value="atx-tower">Dell Pro 2</option>
                <option value="atx-tower">Asus Pro 2</option>
                <option value="atx-tower">Mac Pro 2</option>
            </select>
        </div>
        <div class="progress-container">
            <div class="progress-bar" id="myProgressBar"></div>
        </div>
        <div class="build-container">
            <div class="build-inner-1">
                <ul id="itemList">
                    <li data-value="Item 1" id="processor" class="item-btn">Processor</li>
                    <li data-value="Item 2" id="ram" class="item-btn">RAM</li>
                    <li data-value="Item 3" id="hdd" class="item-btn">Hard disk (HDD)</li>
                    <li data-value="Item 4" id="gpu" class="item-btn">Graphics Driver</li>
                    <li data-value="Item 5" id="ssd" class="item-btn">SSD</li>
                    <li data-value="Item 5" id="monitor" class="item-btn">Monitor</li>
                    <li data-value="Item 5" id="cpu-box" class="item-btn">Computer Case</li>
                    <li data-value="Item 5" id="board" class="item-btn">Motherboard</li>
                    <li data-value="Item 5" id="fan" class="item-btn">Cooling Fans</li>
                </ul>
            </div>
            <div class="build-inner-2">

            </div>
        </div>
        <div class="build-recomendations">
            <h3>Previous build PC recommendations</h3>
            <div class="slider-container">
                <div class="slider">

                    <?php
                    include_once '../utils/dbConnect.php';
                    $conn = OpenCon();
                    $sql = "SELECT image1 FROM build_recommendations";
                    if ($result = mysqli_query($conn, $sql)) {

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<div class='item'>
                                    <img class='img' src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                </div>";
                            }
                        }
                        CloseCon($conn);
                    }
                    ?>
                    <!-- Add more items as needed -->
                </div>
                <button class="prev-button"><img src="../../resources/images/prev-white.png" alt="Next" height="30px" width="auto" onclick="prevSlide()" /></button>
                <button class="next-button"><img src="../../resources/images/next-white.png" alt="Next" height="30px" width="auto" onclick="nextSlide()" /></button>
            </div>
        </div>
    </div>
    <?php include '../components/footer.php'
    ?>
    <script src="../../resources/js/build_slider.js"></script>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var contentDiv = document.querySelector('.build-inner-2');
            var items = document.querySelectorAll('.item-btn');

            // Add click event listeners to list items for selection
            items.forEach(function(item) {
                item.addEventListener('click', function() {
                    // Get the button's ID
                    var buttonId = item.id;

                    // Deselect all items
                    items.forEach(function(btn) {
                        if (btn !== item) {
                            btn.classList.remove('selected');
                        }
                    });

                    // Select the clicked item
                    item.classList.add('selected');

                    // Perform an AJAX request, passing the button's ID as a parameter
                    var xhr = new XMLHttpRequest();
                    console.log(buttonId);
                    xhr.open('GET', '../components/item_category_content.php?id=' + buttonId, true);

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            // Update the content div with the response
                            contentDiv.innerHTML = xhr.responseText;
                        } else {
                            // Handle errors here
                        }
                    };

                    xhr.send();
                });
            });
        });
    </script> -->
</body>

</html>