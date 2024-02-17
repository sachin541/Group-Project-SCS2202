<?php
require_once '../components/headers/main_header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Montserrat Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../resources/css/css_tech/dashboard.css">
</head>

<body>

    <!-- Main -->
    <main class="main-container">

        <div class="main-cards">

            <div class="card">
                <a href="./build_management.php">
                    <div class="card-inner">
                        <h3>ONGOING BUILDS</h3>
                        <span class="material-icons-outlined">build</span>
                    </div>
                    <h1>2</h1>
                </a>
            </div>

            <div class="card">
                <a href="./repair_management.php">
                    <div class="card-inner">
                        <h3>ONGOING REPAIRS</h3>
                        <span class="material-icons-outlined">construction</span>
                    </div>
                    <h1>4</h1>
                </a>
            </div>

            <div class="card">
                <div class="card-inner">
                    <h3>ALL REQUESTS</h3>
                    <span class="material-icons-outlined">toc</span>
                </div>
                <h1>12</h1>
            </div>

            <div class="card">
                <div class="card-inner">
                    <h3>ALERTS</h3>
                    <span class="material-icons-outlined">notification_important</span>
                </div>
                <h1>3</h1>
            </div>

        </div>

        <div class="charts">

            <div class="charts-card">
                <h2 class="chart-title">Timeline</h2>
                <!-- <div id="bar-chart"></div> -->
            </div>

            <div class="charts-card">
                <h2 class="chart-title">Messages</h2>
                <!-- <div id="area-chart"></div> -->
            </div>

        </div>
    </main>
    <!-- End Main -->

    <!-- </div> -->

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="../../resources/js/js_tech/dashboard.js"></script>
</body>

</html>