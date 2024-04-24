<?php
require_once '../components/headers/main_header.php';
require_once '../classes/database.php';
require_once '../classes/reports.php'; 
$category = isset($_POST['type']) ? $_POST['type'] : 'default';

$database = new Database();
$db = $database->getConnection();

$reportObj = new BuildReport($db);


$from = date('Y-m-d' , strtotime("0 day"));
$to = date('Y-m-d', strtotime("-4 month"));

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : $to; // Default start date
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : $from;   // Default end date
$saleType = isset($_GET['saleType']) ? $_GET['saleType'] : 'ALL';        // Default sale type

// $salesByBrandData = $reportObj->getSalesDataForPieChart($startDate, $endDate, "brand", $saleType);
// $salesByCategoryData = $reportObj->getSalesDataForPieChart($startDate, $endDate, "category", $saleType);
$lineChartData = $reportObj->getDailyProfitFromBuilds($startDate, $endDate);

// $lineChartData = $lineChartObj->getSalesDataForLineChart($startDate, $endDate, "InStore"); // Get line chart data
// $lineChartData = $lineChartObj->fetchSalesData($startDate, $endDate); 
// print_r($lineChartObj->getSalesDataForLineChart($startDate, $endDate, "test")); 
// print_r($lineChartObj->processSalesDataForLineChart($lineChartData));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsSideBar.css">
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsBuildsSales.css">
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
                        
                        <h2>Build Sales Reports</h2>
                        
                        <div class="filter-options">

                            <div class="date" >
                            <label for="startDate" class="date-label">From: </label>
                            <input type="date" id="startDate" name="startDate" value="<?php echo htmlspecialchars($startDate); ?>" required>
                            
                            <label for="endDate"> To:</label>
                            <input type="date" id="endDate" name="endDate" value="<?php echo htmlspecialchars($endDate); ?>" required>
                            </div>

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
    
    var ctxLine = document.getElementById('salesLineChart').getContext('2d');
    var salesLineChart = new Chart(ctxLine, {
        type: 'line',
        data: <?php echo json_encode($lineChartData); ?>,
        options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Sales Over Time',
                        font: {
                            size: 18
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                elements: {
                    line: {
                        tension: 0.3 // Smoother lines
                    },
                    point: {
                        radius: 1 // Points on the line
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Sales LKR',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {top: 10, bottom: 10}
                        }
                    },
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 10,
                            maxRotation: 90, // Rotates labels up to 90 degrees
                            minRotation: 60 // Minimum rotation in degrees
                        },
                       
                        title: {
                            display: true,
                            text: 'Date',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {top: 10, bottom: 10}
                        }
                    }
                }
            }
        });



</script>


</body>
</html>
