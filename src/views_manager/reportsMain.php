<?php
$category = isset($_POST['type']) ? $_POST['type'] : 'default';
?>

<?php
require_once '../classes/database.php';
require_once '../classes/reports.php'; 

$database = new Database();
$db = $database->getConnection();
$reportObj = new Report($db);

$startDate = '2024-01-01'; // example start date
$endDate = '2024-01-31';   // example end date

$salesByBrandData = $reportObj->getSalesByBrand($startDate, $endDate);
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
        <div class="grid-item grid-item-3"><canvas id="salesBarChart"></canvas></div>
        <div class="grid-item grid-item-4"><canvas id="categoryDoughnutChart"></canvas></div>
    </div>

</div>

<script>
    // Sample data for the charts
    const salesOverTimeData = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
        datasets: [{
            label: 'Total Revenue',
            data: [12000, 19000, 3000, 5000, 2000, 3000],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    // const salesByBrandData = {
    //     labels: ["Brand A", "Brand B", "Brand C"],
    //     datasets: [{
    //         data: [300, 50, 100],
    //         backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
    //         hoverBackgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"]
    //     }]
    // };
    
    var salesByBrandData = <?php echo json_encode($salesByBrandData); ?>;


    const salesByCategoryData = {
        labels: ["Category X", "Category Y", "Category Z"],
        datasets: [{
            data: [55, 30, 15],
            backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
            hoverBackgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"]
        }]
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Bar Chart - Sales Over Time
        var ctx1 = document.getElementById('salesBarChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: salesOverTimeData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart - Sales % by Brand
        var ctx2 = document.getElementById('brandPieChart').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: salesByBrandData
        });

        // Doughnut Chart - Sales % by Category
        var ctx3 = document.getElementById('categoryDoughnutChart').getContext('2d');
        new Chart(ctx3, {
            type: 'doughnut',
            data: salesByCategoryData
        });
    });
</script>

</body>
</html>




