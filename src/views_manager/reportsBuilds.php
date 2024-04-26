<?php
require_once '../classes/database.php';
require_once '../classes/reports.php'; // Assuming BuildReport class is defined here
require_once '../components/headers/main_header.php';
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'manager' )){
    header('Location: ../views_main/denied.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

$buildReport = new BuildReport($db);

$defaultStartDate = date('Y-m-d', strtotime('-4 weeks'));
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
            <h2>Builds Reports</h2>
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
                label: 'Requests Created',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                data: requestsData,
                fill: false,
                pointRadius: requestsData.map(value => value === 0 ? 1 : 3),
                pointHoverRadius: requestsData.map(value => value === 0 ? 3 : 6),
                lineTension: 0.4 // Smooths the line
            }, {
                label: 'Requets Completed',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                data: completedData,
                fill: false,
                pointRadius: completedData.map(value => value === 0 ? 1 : 3),
                pointHoverRadius: completedData.map(value => value === 0 ? 3 : 6),
                lineTension: 0.4 // Smooths the line
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: 'black' // consistent with the revenue chart
                    }
                },
                title: {
                    display: true,
                    text: 'Build Requests vs. Builds Completed',
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
                        maxRotation: 90, // Rotates each label to 90 degrees
                        minRotation: 60, // Keeps labels slanted to improve readability
                        autoSkip: true, // Automatically skips labels to avoid overlap
                        autoSkipPadding: 20, // Padding between skips (px)
                        major: {
                            enabled: true // Major ticks are enhanced for visibility
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
                        precision: 0, // Avoids decimal values
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
    var ctx = document.getElementById('buildsCompletedChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($technicianNames); ?>,
            datasets: [{
                label: 'Builds Completed',
                data: <?php echo json_encode($completedBuilds); ?>,
                
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
                        color: 'black' // ensures text color is black for better readability
                    }
                },
                title: {
                    display: true,
                    text: 'Builds Completed by Technicians',
                    font: {
                        size: 20
                    },
                    
                    padding: {
                        top: 10,
                        bottom: 20
                    }
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
    var ctx = document.getElementById('buildsStagesPie').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($stageNames); ?>,
            datasets: [{
                label: 'Build Stages',
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
                        padding: 10, // slightly more padding for better legibility
                        color: 'black' // consistent with other charts
                    }
                },
                title: {
                    display: true,
                    text: 'Build Stages Distribution',
                    font: {
                        size: 20
                    },
                    
                    padding: {
                        top: 10,
                        bottom: 20
                    }
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


