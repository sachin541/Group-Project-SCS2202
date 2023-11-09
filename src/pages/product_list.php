<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product Title</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/product_list.css" type="text/css">
    <link rel="stylesheet" href="../../resources/css/content.css" type="text/css">
</head>

<body>

    <?php
    // Initialize the session
    session_start();

    // Check if the user is logged in, show registered header if not then redirect show unregistered header
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        include '../components/unreg_header.php';
    } else {
        include '../components/reg_header.php';
    }
    ?>

    <div class="main-outer">
        <div class="main-side-nav">
            <div class="nav-panel">
                <ul class="nav-item">
                    <li><button class="nav-link" id="rog">
                            <div class="l-img"><img src="../../resources/images/asus.png" alt="Next" height="20px" width="auto" style="margin-right: 5px;" /></div>
                            <div class="txt">ASUS ROG</div>
                        </button></li>
                    <li><button class="nav-link" id="p-asus">
                            <div class="l-img"><img src="../../resources/images/asus.png" alt="Next" height="20px" width="auto" style="margin-right: 5px;" /></div>
                            <div class="txt">POWERED BY ASUS</div>
                        </button></li>
                    <li><button class="nav-link" id="cs-asus">
                            <div class="l-img"><img src="../../resources/images/asus.png" alt="Next" height="20px" width="auto" style="margin-right: 5px;" /></div>
                            <div class="txt">COMMERCIAL SOLUTIONS (ASUS)</div>
                        </button></li>
                    <li><button class="nav-link" id="apple">
                            <div class="l-img"><img src="../../resources/images/apple.png" alt="Next" height="20px" width="auto" style="margin-right: 5px;" /></div>
                            <div class="txt">APPLE PRODUCTS</div>
                        </button></li>
                    <li><button class="nav-link" id="console">
                            <div class="l-img"><img src="../../resources/images/console.png" alt="Next" height="20px" width="auto" style="margin-right: 5px;" /></div>
                            <div class="txt">CONSOLE GAMING</div>
                        </button></li>
                    <li><button class="nav-link clickedButton" id="laptop">
                            <div class="l-img"><img src="../../resources/images/laptop.png" alt="Next" height="20px" width="auto" style="margin-right: 5px;" /></div>
                            <div class="txt">LAPTOPS</div>
                        </button></li>
                    <li><button class="nav-link" id="desktop">
                            <div class="l-img"><img src="../../resources/images/desktop.png" alt="Next" height="20px" width="auto" style="margin-right: 5px;" /></div>
                            <div class="txt">DESKTOP WORKSTATIONS</div>
                        </button></li>
                    <li><button class="nav-link" id="gaming">
                            <div class="l-img"><img src="../../resources/images/desktop.png" alt="Next" height="20px" width="auto" style="margin-right: 5px;" /></div>
                            <div class="txt">GAMING DESKTOPS</div>
                        </button></li>
                    <li><button class="nav-link" id="acc">
                            <div class="l-img"><img src="../../resources/images/accessories.png" alt="Next" height="20px" width="auto" style="margin-right: 5px;" /></div>
                            <div class="txt">ACCESSORIES</div>
                        </button></li>
                </ul>
            </div>
        </div>
        <div class="main-content-box" id="content">

            <div class="item-list">
                <?php
                include_once '../utils/dbConnect.php';
                $conn = OpenCon();
                $sql = "SELECT id, product_name, image1, description, price FROM product WHERE category = 'Laptop'";

                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $formatted_price = number_format($row['price']);
                            echo "<div class='item-card' onclick='clickItem(" . $row['id'] . ")'>
                                    <img src='data:image;base64," . base64_encode($row['image1']) . "'alt='item img' />
                                    <h3>" . $row['product_name'] . "</h3>
                                    <p class='description'>" . $row['description'] . "</p>
                                    <div class='price-container'>
                                        <p class='price'>" . "Rs " . $formatted_price . "/-" . "</p>
                                     </div>
                                </div>";
                        }
                    }
                    CloseCon($conn);
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to the content div and the load buttons
            var contentDiv = document.getElementById('content');
            var loadButtons = document.querySelectorAll('.nav-link');

            // Add event listeners to the load buttons
            loadButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // // Get the button's ID
                    // var buttonId = button.id;

                    // // Change the color of the clicked button
                    // button.classList.add('clickedButton');

                    // // Remove the 'clickedButton' class from other buttons
                    // loadButtons.forEach(function(btn) {
                    //     if (btn !== button) {
                    //         btn.classList.remove('clickedButton');
                    //     }
                    // });

                    // // Perform an AJAX request, passing the button's ID as a parameter
                    // var xhr = new XMLHttpRequest();
                    // console.log(buttonId);
                    // xhr.open('GET', '../components/content.php?id=' + buttonId, true);

                    // xhr.onload = function() {
                    //     if (xhr.status === 200) {
                    //         // Update the content div with the response
                    //         contentDiv.innerHTML = xhr.responseText;
                    //     } else {
                    //         // Handle errors here
                    //     }
                    // };

                    xhr.send();
                });
            });
        });

        function clickItem(productID) {
            window.location.href = "../pages/product.php?prodId=" + productID;
        }

        function getXmlHttpRequestObject() {
            if (window.XMLHttpRequest) {
                return new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                return new ActiveXObject("Microsoft.XMLHTTP");
            } else {}
        }
    </script>

    <?php include '../components/footer.php' ?>
</body>

</html>