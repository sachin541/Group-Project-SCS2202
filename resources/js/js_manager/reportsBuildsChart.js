document.addEventListener('DOMContentLoaded', function () {
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


document.addEventListener('DOMContentLoaded', function () {
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