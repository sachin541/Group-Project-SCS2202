<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/login.css" />
    <link rel="stylesheet" type="text/css" href="../../resources/css/reg.css" />
</head>
<body>

    <script>
    function showSuccessModal() {
        var modal = document.getElementById('successModal');
        var mainContent = document.querySelector('.main-content');
        modal.style.display = "block";
        mainContent.classList.add('blur');
    }

    function closeSuccessModal() {
        var modal = document.getElementById('successModal');
        var mainContent = document.querySelector('.main-content');
        modal.style.display = "none";
        mainContent.classList.remove('blur');
    }
    </script>

    <?php require_once '../components/headers/main_header.php';?>
    <?php
    if (isset($_SESSION['error_message'])) {
        $login_err = $_SESSION['error_message'];
        unset($_SESSION['error_message']); 
    }
    ?>

    <div class="main-content"> 
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
    </div>

    <div id="successModal" class="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" onclick="closeSuccessModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Replace "path/to/success-image.png" with the actual path to your image -->
                    <img src="../../resources/images/newhomepage/blackcheckmark.jpg" alt="Success" >
                    <p>Registration successful.</p>
                </div>
                <div class="modal-footer">
                    <!-- Update this link to point to your login page -->
                    <a href="" class="btn btn-primary" onclick="closeSuccessModal()">Proceed to Login</a>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['registration_success'])): ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        showSuccessModal();
        <?php unset($_SESSION['registration_success']); // Make sure to unset the flag ?>
    });
    </script>
    <?php endif; ?>

</body>
</html>
