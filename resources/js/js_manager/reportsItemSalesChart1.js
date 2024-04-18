document.addEventListener('DOMContentLoaded', function () {
    <?php if ($selectedProductId && !empty($salesDataByItem)): ?>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesData = <?php echo json_encode(array_values($salesDataByItem)); ?>;
        var salesLabels = <?php echo json_encode(array_keys($salesDataByItem)); ?>;

        // For a bar chart, you might not need to customize point colors as in the line chart.
        // However, if you want to customize the bar colors based on the value, you can do so here.

        var chart = new Chart(ctx, {
            type: 'bar', // Changed from 'line' to 'bar'
            data: {
                labels: salesLabels,
                datasets: [{
                    label: 'Total Sales',
                    data: salesData,
                    backgroundColor: salesData.map(value => value === 0 ? 'transparent' : 'rgba(0, 123, 255, 0.5)'), // Optional: make 0 value bars transparent
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Daily Sales for Product ID: <?php echo $selectedProductId; ?>'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        },
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Units Sold'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: true,
                    labels: {
                        // Set font color for the legend text
                        fontColor: '#r', // Example: dark gray
                        // Customize the legend box color
                        usePointStyle: true, // Use point style for a cleaner look
                        // To set box color, you typically adjust the dataset's backgroundColor
                    },
                    // Optionally, set the legend position
                    position: 'top'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                }
            }
        });
    <?php endif; ?>
});