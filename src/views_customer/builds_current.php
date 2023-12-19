<?php
require_once '../classes/database.php';
require_once '../classes/build.php';
require_once '../classes/product.php';
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();
$build = new Build($db);
$product = new Product($db);

$customerId = $_SESSION['user_id']; 
$builds = $build->getBuildsByCustomerId($customerId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Active Builds</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/builds_current.css" />
</head>
<body>
    <div class="main-content">
        <div class="main-title">
            <h2>Active Builds for Customer: <?= htmlspecialchars($customerId) ?></h2>
        </div>

        <div class="table-container">
            <table class="builds-table">
                <thead class="table-head">
                    <tr class="table-header-row">
                        <th class="header-item">Build ID</th>
                        <th class="header-item">Components</th>
                        <th class="header-item">Total Price</th>
                        <th class="header-item">Date Added</th>
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
                                        'Case' => $build['Case_id']
                                    ];
                                    foreach ($componentIds as $component => $id):
                                        $componentDetails = $product->getProductById($id);
                                        if ($componentDetails): ?>
                                            <div class="component-detail">
                                                <img class="component-image" src="data:image/jpeg;base64,<?= base64_encode($componentDetails['image1']) ?>" alt="<?= htmlspecialchars($componentDetails['product_name']) ?>">
                                                <span class="component-name-tooltip">
                                                    <span class="tooltip-content">
                                                        <span class="tooltip-title"><?= htmlspecialchars($componentDetails['product_name']) ?></span>
                                                        <br>
                                                        <span class="tooltip-price">Price: <?= htmlspecialchars($componentDetails['price']) ?></span>
                                                    </span>
                                                </span>
                                            </div>
                                        <?php endif;
                                    endforeach; ?>
                                </div>
                            </td>
                            <td class="row-item total-price"><?= htmlspecialchars($build['amount']) ?></td>
                            <td class="row-item date-added"><?= htmlspecialchars($build['added_timestamp']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>



