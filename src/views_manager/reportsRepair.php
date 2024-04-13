<?php
require_once '../classes/database.php';
require_once '../classes/reports.php'; // Assuming RepairReport class is defined here
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();

$repairReport = new RepairReport($db);

$defaultStartDate = date('Y-m-d', strtotime('-2 weeks'));
$defaultEndDate = date('Y-m-d');

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : $defaultStartDate;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : $defaultEndDate;

$repairRequestsCount = $repairReport->getRepairRequestCountByDateRange($startDate, $endDate);
$repairsCompletedCount = $repairReport->getRepairsCompletedByDateRange($startDate, $endDate);

$repairsCompletedByTechnician = $repairReport->getRepairsCompletedByTechnician($startDate, $endDate);
$technicianNames = array_column($repairsCompletedByTechnician, 'name');
$completedRepairs = array_column($repairsCompletedByTechnician, 'completedRepairs');

$repairsByStage = $repairReport->getRepairCountsByStageAndDateRange($startDate, $endDate);
$stageNames = array_keys($repairsByStage);
$stageCounts = array_values($repairsByStage);

$labels = array_keys($repairRequestsCount);
$requestsData = array_values($repairRequestsCount);
$completedData = array_values($repairsCompletedCount);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Repair Reports</title>
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
            <canvas id="repairsChart"></canvas>
        </div>
        
        <div class="grid-item grid-item-2">
            <canvas id="repairsCompletedChart"></canvas>
        </div>

        <div class="grid-item grid-item-3">
            <canvas id="repairsStagesPie"></canvas>
        </div>
    </div>
</div>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('repairsChart').getContext('2d');
    var labels = <?php echo json_encode($labels); ?>;
    var requestsData = <?php echo json_encode($requestsData); ?>;
    var completedData = <?php echo json_encode($completedData); ?>;
    
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Repair Requests',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                data: requestsData,
                fill: false,
            }, {
                label: 'Repairs Completed',
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
                text: 'Repair Requests vs. Repairs Completed'
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

document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('repairsCompletedChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($technicianNames); ?>,
            datasets: [{
                label: 'Repairs Completed',
                data: <?php echo json_encode($completedRepairs); ?>,
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
                    text: 'Repairs Completed by Technician'
                }
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('repairsStagesPie').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($stageNames); ?>,
            datasets: [{
                label: 'Repair Stages',
                data: <?php echo json_encode($stageCounts); ?>,
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
                    text: 'Repair Stages Distribution'
                }
            }
        }
    });
});
</script>
