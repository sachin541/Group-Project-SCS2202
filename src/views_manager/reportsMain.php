<?php
$category = isset($_POST['type']) ? $_POST['type'] : 'default';

require_once '../classes/database.php';
require_once '../classes/reports.php'; 


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
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsMain.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="main-container">

        <aside class="main-side-nav">
            <?php require_once './reportsSideBar.php'; ?>
        </aside>

        <div class="main-reports-section">
            <div class="grid-item-1">
                <form action="" method="get">
                    <div class="main-filter-section">
                        <div class="filter-heading">
                            <h2>Filter Sales Reports</h2>
                        </div>
                        <div class="filter-options">
                            <label for="startDate" class="date-label">Start Date:</label>
                            <input type="date" id="startDate" name="startDate" value="<?php echo htmlspecialchars($startDate); ?>" required>
                            
                            <label for="endDate">End Date:</label>
                            <input type="date" id="endDate" name="endDate" value="<?php echo htmlspecialchars($endDate); ?>" required>
                            
                            <label for="saleType">Sale Type:</label>
                            <select id="saleType" name="saleType">
                                <option value="ALL" <?php echo $saleType == 'ALL' ? 'selected' : ''; ?>>All</option>
                                <option value="InStore" <?php echo $saleType == 'InStore' ? 'selected' : ''; ?>>Instore</option>
                                <option value="PayOnlineONLY" <?php echo $saleType == 'PayOnlineONLY' ? 'selected' : ''; ?>>Online</option>
                                <option value="DeliveryONLY" <?php echo $saleType == 'DeliveryONLY' ? 'selected' : ''; ?>>On Delivery</option>
                                <option value="PayOnlineAndDelivery" <?php echo $saleType == 'PayOnlineAndDelivery' ? 'selected' : ''; ?>>Online and Delivery</option>
                            </select>
                        </div>
                        <div class="filter-confirm">
                            <button type="submit">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>
        
            <div class="grid-item grid-item-2">
                <canvas id="brandPieChart"></canvas>

            </div>

            <div class="grid-item grid-item-3">
                <canvas id="salesLineChart"></canvas>

            </div>

            <div class="grid-item grid-item-4">
                <canvas id="categoryDoughnutChart"></canvas>
            </div>

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
        data: salesByBrandData,
        options: {
            plugins: {
                legend: {
                    position: 'left',
                    labels: {
                        boxWidth: 20,
                        padding: 15
                    }
                }
            }
        }
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
            data: salesByCategoryData,
            options: {
            plugins: {
                legend: {
                    position: 'left',
                    labels: {
                        boxWidth: 20,
                        padding: 15
                    }
                }
            }
        }
    });
    });
</script>

</body>
</html>





