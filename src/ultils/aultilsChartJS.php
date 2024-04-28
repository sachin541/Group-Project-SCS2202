<?php 

// $h1 = 7 ; 
// $h2 = 7 ; 
// echo $h1 <=> $h2 ; 
// $var1 = "100";
// $var2 = 100;
// var_dump($var1 == $var2);
// var_dump($var1 === $var2);

require_once '../classes/order.php'; 
require_once '../classes/database.php';
$database = new Database();
$db = $database->getConnection(); 
$order = new Order($db);

$data = $order->test(); 
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Slider Value</title>
</head>
<body>
    <form action="handle_slider.php" method="get">
        <label for="amountSlider">Select Amount ($):</label>
        <input type="range" id="amountSlider" name="amount" min="0" max="1000" value="500" step="10">
        <span id="amountValue">$500</span>
        <button type="submit">Submit</button>
    </form>

    <script>
        const slider = document.getElementById('amountSlider');
        const output = document.getElementById('amountValue');

        slider.oninput = function() {
            output.textContent = '$' + this.value;
        }
    </script>
</body>
</html> -->
<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summaries by Date</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Daily Totals</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Sum</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['DATE(created_at)']) . "</td>";
                echo "<td>" . number_format($row['SUM(total)'], 2) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chart Display</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Daily Totals Chart</h1>
    <canvas id="myChart" width="400" height="200"></canvas>
    <script>
        // Assuming the PHP script is part of this file and generates the array
       

        // Convert PHP array to JavaScript array
        var rawData = <?php echo json_encode($data); ?>;
        var labels = rawData.map(function(item) {
            return item['DATE(created_at)'];
        });
        var data = rawData.map(function(item) {
            return item['SUM(total)'];
        });

        // Setup the chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // Change to 'line' for a line chart
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sum',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
