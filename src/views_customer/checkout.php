<?php
require_once '../classes/database.php';
require_once '../classes/cart.php';
require_once '../classes/product.php';
require_once '../classes/order.php';
require_once '../components/headers/main_header.php';


$database = new Database();
$db = $database->getConnection();
$cart = new Cart($db);
$product = new Product($db);
$orderobj = new Order($db);


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$orderDetails = $cart->getCartItemsByUserId($userId);

if (empty($orderDetails)) {
    header('Location: view_cart.php'); 
    exit;
}

function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
    
}
//cal total 
$totalAmount = 0;

foreach ($orderDetails as $item){
    $productDetails = $product->getProductById($item['product_id']);
    $subtotal = $productDetails['price'] * $item['quantity'];
    $totalAmount += $subtotal;
}
$_SESSION['cart_total'] = $totalAmount; 
// $_SESSION["payment_error"] = "Payment failed. Please try again";
$numberOfPendingPayments = $orderobj->countPendingPaymentsByCustomerId(($_SESSION['user_id']));
// echo($numberOfPendingPayments); 

 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delivery Details</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_customer/checkout.css">
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script type="text/javascript">
        
        //function to show pay on delivery confirmation modal 
        function showConfirmationModal() {
            var modal = document.getElementById("confirmationModal");
            var noBtn = document.getElementById("confirmNo");
            var yesBtn = document.getElementById("confirmYes");

            modal.style.display = "block";
            
            noBtn.onclick = function() {
                modal.style.display = "none";
            };
            
            yesBtn.onclick = function() {
                modal.style.display = "none";
                document.querySelector('.checkout-form').submit(); // Submit form on "Yes"
            };
            
            // This handler closes the modal if the user clicks outside of it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
        }

        //function to show pay on delivery declined due to pending payments 
        function showModal() {
            console.log("Payment dismissed");
            var modal = document.getElementById("paymentPendingModal");
            var closeButton = document.getElementsByClassName("close-button")[0];
            var closeModalButton = document.getElementById("closeModal");

            modal.style.display = "block";
            
            closeButton.onclick = function() {
                modal.style.display = "none";
            }
            
            closeModalButton.onclick = function() {
                modal.style.display = "none";
            }
            
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }

        function handleSubmit() {
            var payOnline = document.getElementById('pay_online').checked; //retrieves the current checked state 
            var numberOfPendingPayments = <?= json_encode($numberOfPendingPayments); ?>; // Convert PHP variable to JS
            if (!payOnline && numberOfPendingPayments > 100) {
                //Pay on delivary 
                showModal();
                return false; //dont submit 
            }
            
            if (!payOnline) {
                //Pay on delivery 
                showConfirmationModal();
                return false; //dont submit form if modal is closed 
            }
            
            if (payOnline) {
                buyNow();
                return false; //ALLOWS THE BUYNOW() FUNCTION TO HANDLE THE SUBMIT (oncomplete function in by now)
            }
            
            return true; // Proceed if numberofPending is less and Its pay on delivery 
        }

        function buyNow() {
            // var name = document.getElementById("name");
            // var price = document.getElementById("price");
            // var name = "testing"
            // var price = null 
            // var order_id = null 
            var form = new FormData();
            // form.append("sumbit_type", name.innerHTML);
            // form.append("price", price.innerHTML);
            form.append("sumbit_type", "payment");
            // form.append("price", price);
            // form.append("order_id", order_id);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "process.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.status === 200 && xhr.readyState === 4) {
                var data = JSON.parse(xhr.responseText);

                // Payment completed. It can be a successful failure.
                payhere.onCompleted = function onCompleted(orderId) {
                    console.log("Payment completed. OrderID:" + orderId);
                    // var form = new FormData();
                    // form.append("sumbit_type", "order");
                    var form = document.querySelector('.checkout-form');
                    form.submit(); //SUBMITS FORM FOR ONLINE PAYMENTS
                    
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
                    return_url: undefined, 
                    cancel_url: undefined, 
                    notify_url: "https://fe78-112-134-209-22.ngrok-free.app/red/project/src/ultils/notifyPayHere.php",
                    order_id: data.order_id,
                    items: data.name,
                    amount: data.price,
                    currency: data.currency,
                    hash: data.hash, // *Replace with generated hash retrieved from backend
                    first_name: data.temp,
                    last_name: data.temp,
                    email: data.temp,
                    phone: data.temp,
                    address: data.temp,
                    city: data.temp,
                    country: "Sri Lanka",
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                payhere.startPayment(payment);
                }
            };
            xhr.send(form);
        }

        // document.querySelector('.checkout-form').addEventListener('submit', handleSubmit);
    </script>
</head>
<body>

<div class="main-header">
    <?php require_once '../components/headers/main_header.php'; ?>
</div>

<div class="grid-container">
      <!-- Billing details  -->
    <div class="box-style">
        <h2>Billing Details</h2>
        <form onsubmit="return handleSubmit()" action="../helpers/checkout_handler.php" method="post" class="checkout-form">
            <input type="hidden" name="total_amount" value="<?= htmlspecialchars($totalAmount); ?>">
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($next_order_id); ?>">
            <div class="row">
                <div><label for="first_name">First Name</label><input type="text" id="first_name" name="first_name" placeholder="First Name" required></div>
                <div><label for="last_name">Last Name</label><input type="text" id="last_name" name="last_name" placeholder="Last Name" required></div>
            </div>
        
            <div class="row">
                <div><label for="email">Email</label><input type="email" id="email" name="email" placeholder="Email" required></div>
                <div><label for="phone">Phone</label><input type="text" id="phone" name="phone" placeholder="Phone" required></div>
            </div>
            
            <div class="row">
                <div><label for="province">Province</label><input type="text" id="province" name="province" placeholder="Province" required></div>
                <div><label for="city">City</label><input type="text" id="city" name="city" placeholder="City" required></div>
            </div>
            
            <div><label for="delivery_address">Delivery Address</label><input type="text" id="delivery_address" name="delivery_address" placeholder="Delivery Address" required></div>
            <div><label for="postalcode">Postal Code</label><input type="text" id="postalcode" name="postalcode" placeholder="Postal Code" required></div>
            
            <div class="payment-options"><h3>Payment Options</h3>
                <div><input type="radio" id="pay_delivery" name="payment_method" value="pay_on_delivery" checked><label for="pay_delivery">Pay on Delivery</label></div>
                <div><input type="radio" id="pay_online" name="payment_method" value="pay_online"><label for="pay_online">Pay Online</label></div>
            </div>

            <?php if (isset($_SESSION["payment_error"])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_SESSION["payment_error"]); ?></div>
                <?php unset($_SESSION["payment_error"]); // Unset immediately after displaying ?>
            <?php endif; ?>

            <div><input type="submit" value="Place Order" class="place-order-button"></div>
        </form>


    </div>
    <!--  Order Items -->
    <div class="box-style">
        <div class="components-section">
            <h2 class="components-heading">Order Items</h2>
            <?php if (!empty($orderDetails)): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $item): 
                            $productDetails = $product->getProductById($item['product_id']);
                            $subtotal = $productDetails['price'] * $item['quantity'];
                            
                        ?>
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <?php if ($productDetails['image1']): ?>
                                            <img src="data:image/jpeg;base64,<?= base64_encode($productDetails['image1']) ?>" 
                                            alt="<?= htmlspecialchars($productDetails['product_name']) ?>">
                                        <?php endif; ?>
                                        <h3><?= htmlspecialchars($productDetails['product_name']) ?></h3>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars(formatPrice($productDetails['price'])) ?></td>
                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                <td><?= htmlspecialchars(formatPrice($subtotal)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="total-price-section">
                    <h3>Total Price: <?= formatPrice($totalAmount) ?></h3>
                </div>
            <?php else: ?>
                <p class="not-found">Order items not found.</p>
            <?php endif; ?>
        </div>
    </div>


    <!-- Payment Pending Modal -->
  


    <!-- Second Column: Delivery Details -->
    
</div>

<!-- Payment Pending Check Modal -->
<div id="paymentPendingModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Payment Pending Alert</h2>
        <p>You have more than one pending payment. Please clear your pending payments before proceeding with Pay on Delivery.</p>
        <button id="closeModal">Ok</button>
    </div>
</div>


<!-- Confirmation Modal for Pay on Delivery -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        
        <h2>Confirm Payment Method</h2>
        <p>Are you sure you want to proceed with Pay on Delivery?</p>
        <div style="text-align: center;">
            <button id="confirmYes" class="modal-button">Yes</button>
            <button id="confirmNo" class="modal-button">No</button>
        </div>
    </div>
</div>



</body>
</html>

