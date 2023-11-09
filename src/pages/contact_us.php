<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contact us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../resources/css/contact_us.css" type="text/css">
</head>

<body>
    <?php //include './unreg_header.php'// Initialize the session
        session_start();

        // Check if the user is logged in, show registered header if not then redirect show unregistered header
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            include '../components/unreg_header.php';
        } else {
            include '../components/reg_header.php';
        }
        
    ?>
    <div class="contact-outer-container">
        <div class="contact-inner inner-1">
            <div class="about-us">
                <h1>CONTACT US</h1>
                <div class="about-us-body">
                    <div class="data-box">
                        <img src="../../resources/images/phone.png" alt="call" width="80px" height="80px" class="data-img" />
                        <div>
                            <h3>Call us</h3>
                            <p class="data">076-4320777</p>
                        </div>
                    </div>
                    <div class="data-box">
                        <img src="../../resources/images/gps.png" alt="location" width="80px" height="80px" class="data-img" />
                        <div>
                            <h3>Location</h3>
                            <p class="data">10D Huludagoda Road Mount Lavinia</p>
                        </div>
                    </div>
                    <div class="data-box">
                        <img src="../../resources/images/clock.png" alt="hours" width="80px" height="80px" class="data-img" />
                        <div>
                            <h3>Working Hours</h3>
                            <p class="data">08.00 a.m - 05.00 p.m</p>
                        </div>
                    </div>
                    <div class="map-box">

                    </div>
                </div>
            </div>
        </div>
        <div class="contact-inner inner-2">
            <form action="contact_form.php" method="POST">

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control" placeholder="Enter a valid email" />
                </div>

                <div class="two-inline-box">

                    <div class="form-group">
                        <label for="fname" class="form-label">Firstname</label>
                        <input id="fname" type="text" class="form-control" placeholder="Enter first name" />
                    </div>

                    <div class="form-group">
                        <label for="lname" class="form-label">Lastname</label>
                        <input id="lname" type="text" class="form-control" placeholder="Enter last name" />
                    </div>

                </div>

                <div class="form-group">
                    <label for="msg" class="form-label">Message</label>
                    <textarea id="msg" class="form-control" placeholder="Enter your message" rows="4"></textarea>
                </div>

                <input type="submit" value="Submit" class="submit-btn" />

            </form>
        </div>
    </div>
    <?php //include './footer.php'
    ?>
</body>

</html>