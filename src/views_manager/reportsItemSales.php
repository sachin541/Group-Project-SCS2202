<?php
require_once '../classes/database.php';
require_once '../classes/reports.php';

$database = new Database();
$db = $database->getConnection();
$report = new ItemSales($db);

// Calculate the start date as 6 months back from today
$defaultStartDate = date('Y-m-d', strtotime('-6 months'));
$defaultEndDate = date('Y-m-d'); // Current date as the default end date

// Check if the dates are set in the GET parameters; otherwise, use calculated default dates
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : $defaultStartDate;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : $defaultEndDate;

// Fetch the sales data
$salesData = $report->getProductSalesFromRange($startDate . " 00:00:00", $endDate . " 23:59:59");
?>

<?php require_once '../components/headers/main_header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsSideBar.css">
    <link rel="stylesheet" href="../../resources/css/css_manager/reportsItemSales.css">
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
                        <input type="date" id="startDate" name="startDate" required>

                        <label for="endDate">End Date:</label>
                        <input type="date" id="endDate" name="endDate" required>

                        <input type="submit" value="Filter">
                    </form>
                </div>

                <div class="search-section">
                    <label for="productSearch">Search Product:</label>
                    <input type="text" id="productSearch" placeholder="Enter product name">
                </div>

                <h2>Product Sales Report (<?php echo $startDate; ?> to <?php echo $endDate; ?>)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Total Units Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($salesData as $productSale): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($productSale['product_id']); ?></td>
                                <td><?php echo htmlspecialchars($productSale['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($productSale['total_units']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        
            <div class="grid-item grid-item-2">
                

            </div>

            

            <div class="grid-item grid-item-3">
                
            </div>

        </div>
  
</div>


<script>
    var salesData = <?php echo json_encode($salesData); ?>;
    document.addEventListener('DOMContentLoaded', function() {
        renderTable(salesData.slice(0, 20));
        document.getElementById('productSearch').addEventListener('input', function(e) {
            var searchKeyword = e.target.value.toLowerCase();
            var filteredData = salesData.filter(function(item) {
                return item.product_name.toLowerCase().includes(searchKeyword);
            }).slice(0, 20); // Limit results to 25 items

            renderTable(filteredData);
        });
    });

    function renderTable(data) {
        var tableBody = document.querySelector('table tbody');
        tableBody.innerHTML = ''; // Clear existing table content

        data.forEach(function(item) {
            var row = `<tr>
                <td>${item.product_id}</td>
                <td>${item.product_name}</td>
                <td>${item.total_units}</td>
            </tr>`;
            tableBody.innerHTML += row;
        });
    }
</script>


</body>
</html>