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

    document.addEventListener('DOMContentLoaded', function () {
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