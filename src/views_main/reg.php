<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/reg.css" />
</head>
<body>
    <?php require_once '../components/headers/main_header.php';?>

    <?php
    echo $_SESSION['show_otp_modal'];
    
    if (isset($_SESSION['registration_error'])) {
        $email_already_in_use_err = htmlspecialchars($_SESSION['registration_error']);
        unset($_SESSION['registration_error']);
        
    }
    ?>

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
        <?php if (isset($_SESSION['show_otp_modal']) && $_SESSION['show_otp_modal']): ?>
        <script>
            $(document).ready(function() {
                showOtpModal();
            });
        </script>
        <?php
        // Remember to unset the flag so the modal doesn't show again on refresh
        unset($_SESSION['show_otp_modal']);
        ?>
        <?php endif; ?>
</body>
</html>



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
            <div class="form-group">
                <label for="otp" class="col-form-label">Enter OTP:</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
                <input type="hidden" name="verify_otp" value="1">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Verify OTP</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Example JavaScript to show the modal, adjust as needed
function showOtpModal() {
    $('#otpModal').modal('show');
}
</script>