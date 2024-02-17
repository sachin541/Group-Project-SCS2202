<!-- Template Top -->
<?php require_once '../templates/main_top.php'; ?>

<!-- Stylesheets -->
<link rel="stylesheet" href="../../resources/css/login.css" />

</head>

<body>

    <!-- Header -->
    <?php require_once '../templates/main_header.php'; ?>


    <?php
    if (isset($_SESSION['error_message'])) {
        $login_err = $_SESSION['error_message'];
        unset($_SESSION['error_message']);
    }
    ?>

    <!-- Login Form -->
    <div class="flexbox">

        <div class="outer-container">
            <img class="image" src="../../resources/images/complogo.png" alt="profile icon.png" />



            <form action="../helpers/login_handler.php" method="post" class="form-container">
                <h1 class="title">Log-In</h1>

                <div class="form-group">
                    <label for="email" class="form-label">Your Email</label>
                    <?php
                    if (!empty($login_err)) {
                        echo '<div style="color: red;" class="alert alert-danger">' . $login_err . '</div>';
                    }
                    ?>
                    <input type="text" id="email" name="email" placeholder="Enter e-mail" class="field" />
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Your Password</label>
                    <input type="password" id="password" name="password" placeholder="password" class="field" />
                </div>


                <input type="submit" name="submit" value="Log in" />

                <p>Don't have an account? <a href="reg.php">Sign-up</a> and create an account</p>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <!-- <?php require_once '../templates/main_footer.php'; ?> -->

    <!-- Template Bottom -->
    <?php require_once '../templates/main_bottom.php'; ?>