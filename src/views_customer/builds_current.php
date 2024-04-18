<?php
require_once '../classes/database.php';
require_once '../classes/build.php';
require_once '../classes/product.php';
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();
$buildObj = new Build($db);
$product = new Product($db);

$customerId = $_SESSION['user_id'];
$builds = $buildObj->getBuildsByCustomerId($customerId);

function formatPrice($price)
{
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}
?>


<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" href="/resources/css/css_customer/builds_current.css">


<div class="main-content">
    <div class="main-title">
        <h2>Current Build Requests</h2>
    </div>

    <div class="table-container">
        <table class="builds-table">
            <thead class="table-head">
                <tr class="table-header-row">
                    <th class="header-item">Build ID</th>
                    <th class="header-item">Components</th>
                    <th class="header-item">Total Price</th>
                    <th class="header-item">Date Created</th>
                    <th class="header-item">Actions</th>
                    <th class="header-item">Status</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php foreach ($builds as $build): ?>
                    <tr class="table-row">
                        <td class="row-item build-id"><?= htmlspecialchars($build['build_id']) ?></td>
                        <td class="row-item components-cell">
                            <div class="components-wrapper">
                                <?php
                                $componentIds = [
                                    'CPU' => $build['CPU_id'],
                                    'GPU' => $build['GPU_id'],
                                    'MotherBoard' => $build['MotherBoard_id'],
                                    'Memory' => $build['Memory_id'],
                                    'Storage' => $build['Storage_id'],
                                    'PowerSupply' => $build['PowerSupply_id'],
                                    'Case' => $build['Case_id'],
                                    'CPU Coolers' => $build['CPU_Coolers_id'],
                                    'Monitor' => $build['Monitor_id'],
                                    'Mouse' => $build['Mouse_id'],
                                    'Keyboard' => $build['Keyboard_id']
                                ];

                                foreach ($componentIds as $component => $id):
                                    $componentDetails = $product->getProductById($id);
                                    if ($componentDetails): ?>
                                        <div class="component-detail">
                                            <img class="component-image"
                                                src="data:image/jpeg;base64,<?= base64_encode($componentDetails['image1']) ?>"
                                                alt="<?= htmlspecialchars($componentDetails['product_name']) ?>">
                                            <span class="component-name-tooltip">
                                                <span class="tooltip-content">
                                                    <span
                                                        class="tooltip-title"><?= htmlspecialchars($componentDetails['product_name']) ?></span>
                                                    <br>
                                                    <span class="tooltip-price">Price:
                                                        <?= htmlspecialchars(formatPrice($componentDetails['price'])) ?></span>
                                                </span>
                                            </span>
                                        </div>
                                    <?php endif;
                                endforeach; ?>
                            </div>
                        </td>
                        <td class="row-item total-price"><?= formatPrice(htmlspecialchars($build['amount'])) ?></td>
                        <td class="row-item date-added"><?= htmlspecialchars($build['added_timestamp']) ?></td>
                        <!-- nav -->
                        <td class="row-item view-details">
                            <form action="./build_details.php" method="post">
                                <input type="hidden" name="build_id" value="<?= $build['build_id'] ?>">
                                <input type="submit" value="View Details" class="details-button">
                            </form>
                        </td>

                        <td class="row-item status">
                            <span class="status-badge <?= $buildObj->getStatusClass($build['build_id']) ?>">
                                <?= $buildObj->getStatus($build['build_id']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- navigation  -->
    <div class="main-container-2">
        <!-- <div class="create-build-btn">
                <form method="post" action="./build_create.php">
                    <input type="hidden" name="handler_type" value="submit-build">
                    <button type="submit" class="remove-btn">Create New Build Request!</button>
                </form>
            </div>   -->

        <!-- <div class="view-current-build-btn">
                <form method="post" action="./builds_current.php">
                    <input type="hidden" name="handler_type" value="submit-build">
                    <button type="submit" class="remove-btn">View Active Build Requests!</button>
                </form>
            </div>    -->

        <div class="view-current-build-btn">
            <a href="./build_item_selector.php" class="active-build-btn">Create New Requests</a>
        </div>

    </div>
</div>


<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>