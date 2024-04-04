<script>
    
function showOtpModal() {
    // Get the modal
    var modal = document.getElementById('otpModal');
    var mainContent = document.querySelector('.main-content'); // Get the main content

    // Show the modal
    modal.style.display = "block";
    mainContent.classList.add('blur'); // Add blur effect

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        mainContent.classList.remove('blur'); // Remove blur effect
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            mainContent.classList.remove('blur'); // Remove blur effect
        }
    }
}

<?php if (isset($_SESSION['show_otp_modal']) && $_SESSION['show_otp_modal']): ?>
document.addEventListener('DOMContentLoaded', function() {
    showOtpModal();
});
<?php unset($_SESSION['show_otp_modal']); // Make sure to unset the flag ?>
<?php endif; ?>

</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/login.css" />
    <link rel="stylesheet" type="text/css" href="../../resources/css/reg.css" />
</head>
<body>
    <?php require_once '../components/headers/main_header.php';?>

    <?php
    // echo $_SESSION['show_otp_modal'];
    // $_SESSION['otp_error'] = 'Invalid OTP. Please try again.';
    // $_SESSION['registration_error'] = 'Invalid OTP. Please try again.';
    
    if (isset($_SESSION['registration_error'])) {
        $email_already_in_use_err = htmlspecialchars($_SESSION['registration_error']);
        unset($_SESSION['registration_error']);
        
    }
    ?>
    <!-- OTP Verification Modal -->
    <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpModalLabel">OTP Verification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../helpers/register_handler.php" method="post" id="otpForm">
                <div class="modal-body">
                    <!-- Place for the error message -->
                    
                    <div class="form-group">
                        <label for="otp" class="col-form-label">Enter OTP:</label>
                        <input type="text" class="form-control" id="otp" name="otp" required>
                    </div>
                        <input type="hidden" name="verify_otp" value="1">
                </div>
                <?php if (isset($_SESSION['otp_error'])): ?>
                        <div class="alert-otp">
                            <?php echo $_SESSION['otp_error']; ?>
                        </div>
                        <?php unset($_SESSION['otp_error']); // Clear the error message after displaying ?>
                    <?php endif; ?>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Verify OTP</button>
                </div>
            </form>
            </div>
        </div>
    </div>


    <div class="main-content">                   
    <!-- Registration Form -->
    <div class="flexbox">
        <div class="outer-container">
            <form action="../helpers/register_handler.php" method="post" class="form-container">
                <h1 class="title">Sign-Up</h1>
                
                <div class="form-group">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter e-mail" class="field" />
                </div>

                <div class="form-group">
                    <label for="password1" class="form-label">Your Password</label>
                    <input type="password" id="password1" name="password" placeholder="Password" class="field" />
                </div>

                <div class="form-group">
                    <label for="password2" class="form-label">Confirm Password</label>
                    <input type="password" id="password2" name="password_confirmation" placeholder="Confirm Password" class="field" />
                </div>

                <?php
                if (!empty($email_already_in_use_err)) {
                    echo '<div style="color: red;" class="alert alert-danger">' . $email_already_in_use_err . '</div>';
                }
                ?>

                <input type="submit" name="submit" value="Sign up" />

                <p>Already have an account? <a href="login.php">Login</a> to the existing account</p>
            </form>
            <img class="image" src="../../resources/images/complogo.png" alt="profile icon.png" />
        </div>
    </div>
    </div>
    <script>
    <?php if (isset($_SESSION['show_otp_modal']) && $_SESSION['show_otp_modal']): ?>
        showOtpModal();
        <?php unset($_SESSION['show_otp_modal']); // Make sure to unset the flag ?>
    <?php endif; ?>
    </script>


</body>
</html>






