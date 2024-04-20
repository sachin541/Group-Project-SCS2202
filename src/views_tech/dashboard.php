<!-- template top -->
<?php require_once '../components/templates/main-top.php'; ?>

<!-- stylesheets -->
<link rel="stylesheet" href="../../resources/css/css_tech/dashboard.css">


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

<!-- scripts -->
<script src="../../resources/js/js_tech/dashboard.js"></script>
<!-- ApexCharts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>

<!-- template bottom -->
<?php require_once '../components/templates/main-bottom.php'; ?>