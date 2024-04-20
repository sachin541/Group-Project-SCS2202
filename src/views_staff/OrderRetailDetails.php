<?php
require_once '../classes/database.php';
require_once '../classes/product.php';
require_once '../classes/InStore.php';
require_once '../classes/UserManager.php';

$database = new Database();
$db = $database->getConnection();

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

$product = new Product($db);
$inStore = new InStore($db);
$managerobj = new UserManager();
$orderDetails = [];

try {
    if (!empty($order_id)) {
        $orderDetails = $inStore->getInStoreOrderDetails($order_id);
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
// print_r($orderDetails);

function formatPrice($price)
{
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>


<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" href="/resources/css/css_staff/ViewRetailOrderDetails.css">


<div class="main-header">
    <?php require_once '../components/headers/main_header.php'; ?>
</div>

<div class="grid-container">
    <!-- First Column: Order Items -->
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
                        <?php foreach ($orderDetails as $item): ?>
                            <?php
                            $productDetails = $product->getProductById($item['product_id']);
                            $subtotal = $productDetails['price'] * $item['item_quantity'];
                            ?>
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <?php if ($productDetails['image1']) { ?>
                                            <img src="data:image/jpeg;base64,<?= base64_encode($productDetails['image1']) ?>"
                                                alt="<?= htmlspecialchars($productDetails['product_name']) ?>">
                                        <?php } ?>
                                        <h3><?= htmlspecialchars($productDetails['product_name']) ?></h3>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars(formatPrice($productDetails['price'])) ?></td>
                                <td><?= htmlspecialchars($item['item_quantity']) ?></td>
                                <td><?= htmlspecialchars(formatPrice($subtotal)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="total-price-section">
                    <h3>Total Price: <?= formatPrice($orderDetails[0]['total']) ?></h3>
                </div>
            <?php else: ?>
                <p class="not-found">Order items not found.</p>
            <?php endif; ?>
        </div>
    </div>



    <!-- Second Column: Delivery Details -->
    <div class="box-style">
        <div class="delivery-details">
            <h2 class="components-heading">Order Details</h2>
            <?php if (!empty($orderDetails)): ?>
                <?php $firstItem = $orderDetails[0];
                $staffInfo = $managerobj->getStaffById($firstItem['createdby']);
                $staffName = $staffInfo['staff_name'];

                ?>
                <table class="details-table">
                    <tr>
                        <td>Order ID:</td>
                        <td><?= htmlspecialchars($firstItem['order_id']) ?></td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td><?= htmlspecialchars(formatPrice($firstItem['total'])) ?></td>
                    </tr>
                    <tr>
                        <td>Order Date:</td>
                        <td><?= htmlspecialchars(date("d-m-Y", strtotime($firstItem['created_at']))) ?></td>
                    </tr>
                    <tr>
                        <td>Created By (User ID):</td>
                        <td><?= htmlspecialchars($staffName . " (" . $firstItem['createdby'] . ")") ?></td>
                    </tr>
                    <tr>
                        <td>Payment Type:</td>
                        <td><?= htmlspecialchars($firstItem['payment_type']) ?></td>
                    </tr>
                    <tr>
                        <td>Payment Status:</td>
                        <td><?= htmlspecialchars($firstItem['payment_status'] . " (In Store)") ?></td>
                    </tr>
                    <tr>
                        <td>NIC:</td>
                        <td><?= htmlspecialchars($firstItem['NIC']) ?></td>
                    </tr>
                    <tr>
                        <td>Recipient Name:</td>
                        <td><?= htmlspecialchars($firstItem['first_name'] . " " . $firstItem['last_name']) ?></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><?= htmlspecialchars($firstItem['phone']) ?></td>
                    </tr>
                </table>

            <?php else: ?>
                <p class="not-found">Delivery details not found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>