<?php
require_once '../components/headers/main_header.php';
require_once '../classes/product.php';
require_once '../classes/UserManager.php'; 
require_once '../classes/reports.php';
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'manager' )){
    header('Location: ../views_main/denied.php');
    exit;
}
$database = new Database();
$db = $database->getConnection();
$productobj = new Product($db);
$userManager= new UserManager($db);
$numberOfStaff = $userManager->getNumberOfStaff();
$numberOfCustomers = $userManager->getNumberOfCustomers();
$ActiveOrders = $userManager->getNumberOfDeliveries();

$endDate = date('Y-m-d'); // Today's date
$startDate = date('Y-m-d', strtotime('-30 days')); // 30 days ago

// Fetch the top 5 products sold in the last 30 days
$report = new ItemSales($db);
$topProducts = $report->getProductSalesFromRange($startDate, $endDate);
// Ensure we only get the top 5 products
$topProducts = array_slice($topProducts, 0, 5);
$ordersLastWeek = $userManager->lastweekorders(); 
// Prepare data for the chart
$productNames = [];
$productSales = [];


foreach ($topProducts as $product) {
    $productNames[] = $product['product_name'];
    $productSales[] = $product['total_units'];
    
}

$currentDate = date('Y-m-d'); // Today's date
$weekAgoDate = date('Y-m-d', strtotime('-6 days')); // Date 6 days ago

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../resources/css/css_manager/dashboard.css">
</head>

<body>

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
                    <h3>Active Deliveris</h3>
                    <span class="material-icons-outlined">notification_important</span>
                </div>
                <h1><?= $ActiveOrders ?></h1>
            </div>

        </div>

        <div class="charts">

            <div class="charts-card">
                <h2 class="chart-title">Top 5 Products</h2>
                <div id="bar-chart"></div>
            </div>

            <div class="charts-card">
                <h2 class="chart-title">Orders Last Week (<?= $weekAgoDate; ?> - <?= $currentDate; ?>)</h2>
                <div id="area-chart"></div>
            </div>


        </div>
    </main>
    <!-- End Main -->

    <!-- </div> -->
    <script>
        let productNames = <?php echo json_encode($productNames); ?>;
        let productSales = <?php echo json_encode($productSales); ?>;
        // Assuming you have images data prepared
        let productImages = <?php echo json_encode($productImages ?? []); ?>;
    </script>
    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Custom JS -->
    <script src="../../resources/js/js_manager/dashboard.js"></script>
</body>


<script>
document.addEventListener('DOMContentLoaded', function () {
    let ordersData = <?php echo json_encode($ordersLastWeek); ?>;
    let orderDates = ordersData.map(data => data.order_date);
    let orderCounts = ordersData.map(data => parseInt(data.order_count));

    const areaChartOptions = {
        series: [{
            name: 'Orders',
            data: orderCounts
        }],
        chart: {
            type: 'area',
            height: 350,
            background: 'transparent',
            stacked: false,
            toolbar: {
              show: false
            }
        },
        colors: ['#00ab57', '#d50000'],
        dataLabels: {
            enabled: false
        },
        fill: {
            gradient: {
                opacityFrom: 0.4,
                opacityTo: 0.1,
                shadeIntensity: 1,
                stops: [0, 100],
                type: 'vertical'
            },
            type: 'gradient'
        },
        grid: {
            borderColor: '#55596e',
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        legend: {
            labels: {
                colors: '#f5f7ff'
            },
            show: true,
            position: 'top'
        },
        markers: {
            size: 6,
            strokeColors: '#1b2635',
            strokeWidth: 3
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'datetime',
            categories: orderDates,
            axisTicks: {
                show: true
            },
            axisBorder: {
                show: true,
                color: '#55596e'
            },
            labels: {
                style: {
                    colors: '#f5f7ff'
                },
                format: 'dd MMM', // Format dates as '10 Feb'
                rotate: -45,
                rotateAlways: true
            },
            
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#f5f7ff'
                }
            },
            title: {
                text: 'Number of Orders',
                style: {
                    color: '#f5f7ff',
                    fontSize: '16px'
                }
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            theme: 'dark',
            x: {
                format: 'dd MMM yyyy' // Full date format in tooltip
            }
        }
    };

    const areaChart = new ApexCharts(document.querySelector('#area-chart'), areaChartOptions);
    areaChart.render();
});
</script>




</html>