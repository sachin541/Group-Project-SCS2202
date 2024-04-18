<?php
require_once '../classes/product.php';
require_once '../classes/UserManager.php';
require_once '../classes/reports.php';

$database = new Database();
$db = $database->getConnection();
$productobj = new Product($db);
$userManager = new UserManager($db);
$numberOfStaff = $userManager->getNumberOfStaff();
$numberOfCustomers = $userManager->getNumberOfCustomers();


$endDate = date('Y-m-d'); // Today's date
$startDate = date('Y-m-d', strtotime('-30 days')); // 30 days ago

// Fetch the top 5 products sold in the last 30 days
$report = new ItemSales($db);
$topProducts = $report->getProductSalesFromRange($startDate, $endDate);
// Ensure we only get the top 5 products
$topProducts = array_slice($topProducts, 0, 5);

// Prepare data for the chart
$productNames = [];
$productSales = [];


foreach ($topProducts as $product) {
    $productNames[] = $product['product_name'];
    $productSales[] = $product['total_units'];

}
?>

<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" href="../../resources/css/css_manager/dashboard.css">

<!-- Main -->
<main class="main-container">

    <div class="main-cards">

        <div class="card">
            <div class="card-inner">
                <h3>PRODUCTS</h3>
                <span class="material-icons-outlined">inventory_2</span>
            </div>
            <h1><?php echo $productobj->getTotalNumberOfProducts(); ?></h1>
        </div>

        <div class="card">
            <div class="card-inner">
                <h3>STAFF</h3>
                <span class="material-icons-outlined">category</span>
            </div>
            <h1><?php echo $numberOfStaff; ?></h1>
        </div>

        <div class="card">
            <div class="card-inner">
                <h3>CUSTOMERS</h3>
                <span class="material-icons-outlined">groups</span>
            </div>
            <h1><?php echo $numberOfCustomers; ?></h1>
        </div>

        <div class="card">
            <div class="card-inner">
                <h3>ALERTS</h3>
                <span class="material-icons-outlined">notification_important</span>
            </div>
            <h1>56</h1>
        </div>

    </div>

    <div class="charts">

        <div class="charts-card">
            <h2 class="chart-title">Top 5 Products</h2>
            <div id="bar-chart"></div>
        </div>

        <div class="charts-card">
            <h2 class="chart-title">Purchase and Sales Orders</h2>
            <div id="area-chart"></div>
        </div>

    </div>
</main>
<!-- End Main -->

<!-- </div> -->

<!-- Scripts -->
<script src="/resources/js/js_manager/dashboard.js"></script>
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>

<!-- this script copied to dashboard.js -->
<!-- <script>
    let productNames = <?php echo json_encode($productNames); ?>;
    let productSales = <?php echo json_encode($productSales); ?>;
    // Assuming you have images data prepared
    let productImages = <?php echo json_encode($productImages ?? []); ?>;
</script> -->