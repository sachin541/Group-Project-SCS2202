<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" href="/resources/css/login.css" />
<!-- <link rel="stylesheet" href="/resources/css/reg.css" /> -->


<!-- this script copied to successModal.js -->
<!-- <script>
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
</script> -->


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

                <p class="end-p">Don't have an account? <a href="reg.php">Sign-up</a> and create an account</p>
            </form>
        </div>
    </div>
</div>

<div id="successModal" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Replace "path/to/success-image.png" with the actual path to your image -->
                <img src="../../resources/images/newhomepage/blackcheckmark.jpg" alt="Success">
                <p>Registration successful.</p>
            </div>
            <div class="modal-footer">
                <!-- Update this link to point to your login page -->
                <p class="btn btn-primary" onclick="closeSuccessModal()">Close</a>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['registration_success'])): ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showSuccessModal();
            <?php unset($_SESSION['registration_success']); // Make sure to unset the flag ?>
        });
    </script>
<?php endif; ?>

<!-- scripts -->
<script src="/resources/js/js_main/successModal.js"></script>

<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>