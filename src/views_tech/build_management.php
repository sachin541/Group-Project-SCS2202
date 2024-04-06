<?php
require_once '../classes/database.php'; 
require_once '../classes/build.php'; // Change to the Build class
require_once '../classes/product.php'; 
require_once '../components/headers/main_header.php';

$technicianId = $_SESSION['user_id'];

$buildFilter = isset($_GET['build_filter']) ? $_GET['build_filter'] : 'active'; // Use build_filter

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$buildobj = new Build($db);

function formatPrice($price) {
    return 'Rs. ' . number_format($price, 2, '.', ',') . '/-';
}

$allBuilds = $buildobj->getAllNewBuilds(); // Fetch all new builds

$myBuilds = $buildobj->getTechnicianBuildsbyID($technicianId, $buildFilter); // Fetch builds by technician ID

?>

<!DOCTYPE html>
<html>
<head>
    <title>All Builds</title>
    <link rel="stylesheet" type="text/css" href="../../resources/css/css_tech/build_management.css"> 
    <!-- <link rel="stylesheet" type="text/css" href="../../resources/css/css_tech/build_management_sub.css"> -->
</head>

<body>
    <h1>All Builds</h1>

    
    <div class="flex-container">

        
        <div class="table-container column">
            <h2>New Builds</h2>
            <?php if(empty($allBuilds)): ?>
                <p>No new builds!</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th class="column-build-id">ID</th>
                            <th class="column-customer-name">Customer</th>
                            <th class="column-components">Components</th>
                            <th class="column-status">Status</th>
                            <th class="column-details">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allBuilds as $build): ?>
                            <?php $statusData = $buildobj->getBuildStatus($build); ?>
                            <tr>
                                <td><?= htmlspecialchars($build['build_id']) ?></td>
                                <td><?= htmlspecialchars($build['customer_name']) ?></td>
                                <!-- Add a new cell for components -->

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
                                            // Add new components here
                                            'CPU Coolers' => $build['CPU_Coolers_id'] ?? null,
                                            'Monitor' => $build['Monitor_id'] ?? null,
                                            'Mouse' => $build['Mouse_id'] ?? null,
                                            'Keyboard' => $build['Keyboard_id'] ?? null,
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
                                                            <span class="tooltip-price">Price: <?= htmlspecialchars(formatPrice($componentDetails['price'])) ?></span>
                                                        </span>
                                                    </span>
                                                </div>
                                            <?php endif;
                                        endforeach; ?>
                                    </div>
                                </td>   

                                <td><span class="status-badge <?= $statusData[1] ?>"><?= $statusData[0] ?></span></td>

                                <td class="details-button-cell">
                                    <form action="build_details.php" method="post">
                                        <input type="hidden" name="build_id" value="<?= $build['build_id'] ?>">
                                        <input type="submit" value="Details" class="button-like-link">
                                    </form>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
                                     
        <!-- Your Builds Section -->
        <div class="table-container column">
            <h2>Your Builds</h2>

            <?php if(empty($myBuilds)): ?>
                <p>No builds assigned to you!</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Build ID</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($myBuilds as $build): ?>
                            <?php $statusData = $buildobj->getBuildStatus($build); ?>
                            <tr>
                                <td><?= htmlspecialchars($build['build_id']) ?></td>
                                <td><?= htmlspecialchars($build['customer_name']) ?></td>
                                <td><span class="status-badge <?= $statusData[1] ?>"><?= $statusData[0] ?></span></td>
                                <td class="details-button-cell">
                                    <form action="build_details.php" method="post">
                                        <input type="hidden" name="build_id" value="<?= $build['build_id'] ?>">
                                        <input type="submit" value="Details" class="button-like-link">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- Filter Form -->
            <form action="" method="get" class="filter-form">
                <select name="build_filter">
                    <option value="all" <?php echo ($buildFilter == 'all') ? 'selected' : ''; ?>>All Builds</option>
                    <option value="completed" <?php echo ($buildFilter == 'completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="active" <?php echo ($buildFilter == 'active') ? 'selected' : ''; ?>>Active</option>
                </select>
                <input type="submit" value="Filter">
            </form>
        </div>
    </div>
</body>
</html>

