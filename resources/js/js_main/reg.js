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
    span.onclick = function () {
        modal.style.display = "none";
        mainContent.classList.remove('blur'); // Remove blur effect
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
            mainContent.classList.remove('blur'); // Remove blur effect
        }
    }
}

<?php if (isset($_SESSION['show_otp_modal']) && $_SESSION['show_otp_modal']): ?>
    document.addEventListener('DOMContentLoaded', function () {
        showOtpModal();
    });
    <?php unset($_SESSION['show_otp_modal']); // Make sure to unset the flag ?>
<?php endif; ?>
