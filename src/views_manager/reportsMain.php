<?php
$category = isset($_POST['type']) ? $_POST['type'] : 'default';

require_once '../classes/database.php';
require_once '../classes/reports.php'; 
require_once '../classes/reportsLineChart.php'; // Include the LineChart class

$database = new Database();
$db = $database->getConnection();

$reportObj = new Report($db);
$lineChartObj = new LineChart($db); // Create an instance of LineChart

$startDate = '2024-01-01'; // example start date
$endDate = '2024-01-31';   // example end date

$salesByBrandData = $reportObj->getSalesDataForPieChart($startDate, $endDate, "brand", "InStore");
$salesByCategoryData = $reportObj->getSalesDataForPieChart($startDate, $endDate, "category", "InStore");
$lineChartData = $lineChartObj->getSalesDataForLineChart($startDate, $endDate, "test");
// $lineChartData = $lineChartObj->getSalesDataForLineChart($startDate, $endDate, "InStore"); // Get line chart data
// $lineChartData = $lineChartObj->fetchSalesData($startDate, $endDate); 
print_r($lineChartObj->getSalesDataForLineChart($startDate, $endDate, "test")); 
// print_r($lineChartObj->processSalesDataForLineChart($lineChartData));
?>

<?php require_once '../components/headers/main_header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports</title>
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsSideBar.css">
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsMain.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="main-container">
    <aside class="main-side-nav">
        <?php require_once './reportsSideBar.php'; ?>
    </aside>

    <div class="main-reports-section">
        <div class="grid-item grid-item-1">Item 1</div>
        <div class="grid-item grid-item-2"><canvas id="brandPieChart"></canvas></div>
        <div class="grid-item grid-item-3"><canvas id="salesLineChart"></canvas></div>
        <div class="grid-item grid-item-4"><canvas id="categoryDoughnutChart"></canvas></div>
    </div>
</div>

<script>
    var salesByBrandData = <?php echo json_encode($salesByBrandData); ?>;
    var salesByCategoryData = <?php echo json_encode($salesByCategoryData); ?>;
    var salesLineChartData = <?php echo json_encode($lineChartData); ?>;
    //   var salesLineChartData = {
    //     "labels": ["2024-01-26", "2024-01-27", "2024-01-28", "2024-01-29"],
    //     "datasets": [
    //         {
    //             "label": "Total Sales",
    //             "data": [6958500, 2554000, 3993500, 595100],
    //             "fill": false,
    //             "borderColor": "rgb(75, 192, 192)",
    //             "tension": 0.1
    //         }
    //     ]
    // };

    document.addEventListener('DOMContentLoaded', function() {
        // Pie Chart - Sales % by Brand
        var ctxBrandPieChart = document.getElementById('brandPieChart').getContext('2d');
        new Chart(ctxBrandPieChart, {
            type: 'pie',
            data: salesByBrandData
        });

        // Line Chart - Sales Over Time
        var ctxLineChart = document.getElementById('salesLineChart').getContext('2d');
        new Chart(ctxLineChart, {
            type: 'line',
            data: salesLineChartData
        });

        // Doughnut Chart - Sales % by Category
        var ctxCategoryDoughnutChart = document.getElementById('categoryDoughnutChart').getContext('2d');
        new Chart(ctxCategoryDoughnutChart, {
            type: 'doughnut',
            data: salesByCategoryData
        });
    });
</script>

</body>
</html>





