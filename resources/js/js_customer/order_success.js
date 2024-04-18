document.addEventListener("DOMContentLoaded", function () {
    // Automatically show the modal
    var modal = document.getElementById("deliveryNotificationModal");
    modal.style.display = "block";

    // Close the modal when the user clicks on <span> (x)
    document.querySelector(".close-modal").onclick = function () {
        modal.style.display = "none";
    };

    // Close the modal on "OK" button click
    document.getElementById("okButton").onclick = function () {
        modal.style.display = "none";
    };

    // Close the modal if the user clicks anywhere outside of it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});