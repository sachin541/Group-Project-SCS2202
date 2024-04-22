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
        <h2>Repairs Report</h2>
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
                pointRadius: requestsData.map(value => value === 0 ? 1 : 3), // Conditional radius based on value
                pointHoverRadius: requestsData.map(value => value === 0 ? 3 : 6), // Larger on hover
                lineTension: 0.4 // Slightly smooths lines for better visual appeal
            }, {
                label: 'Repairs Completed',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                data: completedData,
                fill: false,
                pointRadius: completedData.map(value => value === 0 ? 1 : 3),
                pointHoverRadius: completedData.map(value => value === 0 ? 3 : 6),
                lineTension: 0.4
            }]
        },
        options: {
            responsive: true,
            
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: 'black'
                    }
                },
                title: {
                    display: true,
                    text: 'Repair Requests vs. Repairs Completed',
                    font: {
                        size: 20
                    },
                    padding: {
                        top: 10,
                        bottom: 30
                    },
                    
                },
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    bodyFont: {
                        size: 14
                    },
                    titleFont: {
                        size: 14
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        maxRotation: 90,
                        minRotation: 60,
                        autoSkip: true,
                        autoSkipPadding: 20,
                        major: {
                            enabled: true
                        },
                        color: '#000' // Black text for better readability
                    },
                    grid: {
                        display: false // Hide grid lines on x-axis
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#000' // Black text for better readability
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)', // Light grey grid lines
                        display: true // Optionally visible y-axis grid lines for clarity
                    }
                }
            }
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('repairsCompletedChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($technicianNames); ?>,
            datasets: [{
                label: 'Repairs Completed',
                data: <?php echo json_encode($completedRepairs); ?>,
                
                
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: 'black', // consistent with the line chart
                        padding: 10
                    }
                },
                title: {
                    display: true,
                    text: 'Repairs Completed by Technician',
                    font: {
                        size: 20
                    },
                    padding: {
                        top: 10,
                        bottom: 20
                    },
                    
                },
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('repairsStagesPie').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($stageNames); ?>,
            datasets: [{
                label: 'Repair Stages',
                data: <?php echo json_encode($stageCounts); ?>,
                
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: 'black', // ensures text color is black for better readability
                        padding: 10
                    }
                },
                title: {
                    display: true,
                    text: 'Repair Stages Distribution',
                    font: {
                        size: 20
                    },
                    padding: {
                        top: 10,
                        bottom: 20
                    },
                    
                },
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
});
</script>
