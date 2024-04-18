// Function to change page based on toggle state
function changePage() {
    window.location.href = document.getElementById('pageToggle').checked ? 'OrdersDeliverySub.php' : 'OrdersRetailSub.php';
}

document.addEventListener('DOMContentLoaded', function () {
    // Set the toggle state based on local storage value
    var savedState = localStorage.getItem('toggleState') === 'true';
    document.getElementById('pageToggle').checked = savedState;

    // Add event listener to the toggle
    document.getElementById('pageToggle').addEventListener('change', function () {
        // Save the new state to local storage
        localStorage.setItem('toggleState', this.checked);
        // Change page
        changePage();
    });
});