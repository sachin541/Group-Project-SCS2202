<?php
$category = isset($_POST['type']) ? $_POST['type'] : 'default';

require_once '../classes/database.php';
require_once '../classes/reports.php'; 
require_once '../classes/reportsLineChart.php'; // Include the LineChart class

$database = new Database();
$db = $database->getConnection();

$reportObj = new PieChart($db);
$lineChartObj = new LineChart($db); // Create an instance of LineChart

$today = date('Y-m-d');

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '2024-01-01'; // Default start date
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '2024-01-31';   // Default end date
$saleType = isset($_GET['saleType']) ? $_GET['saleType'] : 'ALL';        // Default sale type

$salesByBrandData = $reportObj->getSalesDataForPieChart($startDate, $endDate, "brand", $saleType);
$salesByCategoryData = $reportObj->getSalesDataForPieChart($startDate, $endDate, "category", $saleType);
$lineChartData = $lineChartObj->getSalesDataForLineChart($startDate, $endDate, $saleType);




// $lineChartData = $lineChartObj->getSalesDataForLineChart($startDate, $endDate, "InStore"); // Get line chart data
// $lineChartData = $lineChartObj->fetchSalesData($startDate, $endDate); 
// print_r($lineChartObj->getSalesDataForLineChart($startDate, $endDate, "test")); 
// print_r($lineChartObj->processSalesDataForLineChart($lineChartData));
?>

<?php require_once '../components/headers/main_header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsSideBar.css">
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsItemSales.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="main-container">

        <aside class="main-side-nav">
            <?php require_once './reportsSideBar.php'; ?>
        </aside>

        <div class="main-reports-section">
            
            <div class="grid-item grid-item-1">
                
            </div>
        
            <div class="grid-item grid-item-2">
                

            </div>

            <div class="grid-item grid-item-3">
                

            </div>

            <div class="grid-item grid-item-4">
                
            </div>

        </div>
  
</div>



</body>
</html>