<?php
require_once '../classes/database.php';
require_once '../classes/reports.php'; // Assuming BuildReport class is defined here
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();

$buildReport = new BuildReport($db);

$defaultStartDate = date('Y-m-d', strtotime('-2 weeks'));
$defaultEndDate = date('Y-m-d');

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : $defaultStartDate;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : $defaultEndDate;

$buildRequestsCount = $buildReport->getBuildRequestCountByDateRange($startDate, $endDate);
$buildsCompletedCount = $buildReport->getBuildsCompletedByDateRange($startDate, $endDate);

$buildsCompletedByTechnician = $buildReport->getBuildsCompletedByTechnician($startDate, $endDate);
// print_r($buildsCompletedByTechnician)  ;
$technicianNames = array_column($buildsCompletedByTechnician, 'name');
$completedBuilds = array_column($buildsCompletedByTechnician, 'completedBuilds');

// print_r($buildsCompletedByTechnician);
// Prepare data for Chart.js
$labels = array_keys($buildRequestsCount);
$requestsData = array_values($buildRequestsCount);
$completedData = array_values($buildsCompletedCount);


//2nd pie chart 
$buildsByStage = $buildReport->getBuildCountsByStageAndDateRange($startDate, $endDate);
$stageNames = array_keys($buildsByStage);
$stageCounts = array_values($buildsByStage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Build Reports</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsSideBar.css">
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsBuild.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="main-container">
    <aside class="main-side-nav">
        <?php require_once './reportsSideBar.php'; ?>
    </aside>

    <div class="main-reports-section">
        <div class="grid-item grid-item-1">
            <div class="filter-date">
                <form action="" method="GET">
                    <label for="startDate">Start Date:</label>
                    <input type="date" id="startDate" name="startDate" value="<?php echo $startDate; ?>" required>

                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate" name="endDate" value="<?php echo $endDate; ?>" required>
                    <input type="submit" value="Filter">
                </form>

                
            </div>

            
            <canvas id="buildsChart"></canvas>
        </div>
        
        <div class="grid-item grid-item-2">
            <!-- Canvas for Chart.js -->
            <canvas id="buildsCompletedChart"></canvas>
            
        </div>

        <div class="grid-item grid-item-3">
            <canvas id="buildsStagesPie"></canvas>
        </div>
    </div>
</div>


</body>
</html>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('buildsChart').getContext('2d');
    
    var labels = <?php echo json_encode($labels); ?>;
    var requestsData = <?php echo json_encode($requestsData); ?>;
    var completedData = <?php echo json_encode($completedData); ?>;
    
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Build Requests',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                data: requestsData,
                fill: false,
            }, {
                label: 'Builds Completed',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                data: completedData,
                fill: false,
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Build Requests vs. Builds Completed'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Date'
                    }
                }],
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Number'
                    }
                }]
            }
        }
    });
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('buildsCompletedChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($technicianNames); ?>,
            datasets: [{
                label: 'Builds Completed',
                data: <?php echo json_encode($completedBuilds); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    
                },
                title: {
                    display: true,
                    text: 'Builds Completed by Technician'
                }
            }
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('buildsStagesPie').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($stageNames); ?>,
            datasets: [{
                label: 'Build Stages',
                data: <?php echo json_encode($stageCounts); ?>,
                backgroundColor: [
                    // Add more colors if you have more stages
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    // Add more border colors if you have more stages
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                    padding: 8 // Increase padding between legend items
                }
                },
                title: {
                    display: true,
                    text: 'Build Stages Distribution'
                }
            }
        }
    });
});

</script>
