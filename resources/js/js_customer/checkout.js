function showConfirmationModal() {
    var modal = document.getElementById("confirmationModal");
    var noBtn = document.getElementById("confirmNo");
    var yesBtn = document.getElementById("confirmYes");
    
    modal.style.display = "block";
    
    noBtn.onclick = function () {
        modal.style.display = "none";
    };
    
    yesBtn.onclick = function () {
        modal.style.display = "none";
        document.querySelector('.checkout-form').submit(); // Submit form on "Yes"
    };
    
    // This handler closes the modal if the user clicks outside of it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}


function showModal() {
    var modal = document.getElementById("paymentPendingModal");
    var closeButton = document.getElementsByClassName("close-button")[0];
    var closeModalButton = document.getElementById("closeModal");
    
    modal.style.display = "block";
    
    closeButton.onclick = function () {
        modal.style.display = "none";
    }
    
    closeModalButton.onclick = function () {
        modal.style.display = "none";
    }
    
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function handleSubmit() {
    var payOnline = document.getElementById('pay_online').checked;
    var numberOfPendingPayments = <?= json_encode($numberOfPendingPayments); ?>; // Convert PHP variable to JS
    if (!payOnline && numberOfPendingPayments > 100) {
        showModal();
        return false; // Prevent form submission
    }
    
    if (!payOnline) {
        // Show confirmation dialog for Pay on Delivery
        showConfirmationModal();
        return false;
    }
    
    if (payOnline) {
        buyNow();
        return false;
    }
    
    return true; // Proceed with form submission if all checks pass
}

function buyNow() {
    // var name = document.getElementById("name");
    // var price = document.getElementById("price");
    var name = "testing"
    var price = 120
    var form = new FormData();
    // form.append("name", name.innerHTML);
    // form.append("price", price.innerHTML);
    form.append("name", name);
    form.append("price", price);
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.status === 200 && xhr.readyState === 4) {
            var data = JSON.parse(xhr.responseText);
            
            // Payment completed. It can be a successful failure.
            payhere.onCompleted = function onCompleted(orderId) {
                console.log("Payment completed. OrderID:" + orderId);
                var form = document.querySelector('.checkout-form');
                form.submit();
            };
            
            // Payment window closed
            payhere.onDismissed = function onDismissed() {
                // Note: Prompt user to pay again or show an error page
                console.log("Payment dismissed");
            };
            
            // Error occurred
            payhere.onError = function onError(error) {
                // Note: show an error page
                console.log("Error:" + error);
            };
            
            // Put the payment variables here
            var payment = {
                sandbox: true,
                merchant_id: data.merchant_id, // Replace your Merchant ID
                return_url: undefined, // Important
                cancel_url: undefined, // Important
                notify_url: "http://sample.com/notify",
                    order_id: data.order_id,
                    items: data.name,
                    amount: data.price,
                    currency: data.currency,
                    hash: data.hash, // *Replace with generated hash retrieved from backend
                    first_name: "test",
                    last_name: "test",
                    email: "test@gmail.com",
                phone: "0771234567",
                address: "test",
                city: "Colombo",
                country: "Sri Lanka",
            };
            
            // Show the payhere.js popup, when "PayHere Pay" is clicked
            payhere.startPayment(payment);
        }
    };
    xhr.send(form);
}

document.querySelector('.checkout-form').addEventListener('submit', handleSubmit);