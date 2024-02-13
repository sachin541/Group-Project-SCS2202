<?php
require_once '../classes/database.php';
require_once '../classes/reports.php';
require_once '../components/headers/main_header.php';

$database = new Database();
$db = $database->getConnection();
$report = new ItemSales($db);

// Calculate the start date as 6 months back from today
$defaultStartDate = date('Y-m-d', strtotime('-6 months'));
$defaultEndDate = date('Y-m-d'); // Current date as the default end date

// Check if the dates are set in the GET parameters; otherwise, use calculated default dates
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : $defaultStartDate;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : $defaultEndDate;

// Retrieve the search term from URL parameters if available
$searchTerm = isset($_GET['productSearch']) ? $_GET['productSearch'] : '';

// Fetch the sales data, modified to potentially include search term filtering
$salesData = $report->getProductSalesFromRange($startDate . " 00:00:00", $endDate . " 23:59:59", $searchTerm);


echo $_SESSION['selectedProductId'];
?>

<?php  ?>

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
                    <input type="date" id="startDate" name="startDate" value="<?php echo $startDate; ?>" required>

                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate" name="endDate" value="<?php echo $endDate; ?>" required>

                    <!-- Include the search term as a hidden field to maintain it across filters -->
                    <input type="hidden" name="productSearch" value="<?php echo htmlspecialchars($searchTerm); ?>">

                    <input type="submit" value="Filter">
                </form>
            </div>

            <div class="search-section">
                <label for="productSearch">Search Product:</label>
                <input type="text" id="productSearch" placeholder="Enter product name" value="<?php echo htmlspecialchars($searchTerm); ?>">
            </div>

            <div class="product-table">
                <h2>Product Sales Report (<?php echo $startDate; ?> to <?php echo $endDate; ?>)</h2>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Total Units Sold</th>
                                <th>Unit Price</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <!-- Scrollable wrapper for the table body -->
                <div class="scrollable-table-body-container">
                    <div class="table-wrapper">
                        <table>
                            <tbody>
                                <?php foreach ($salesData as $productSale): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($productSale['product_id']); ?></td>
                                        <td>
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($productSale['image']); ?>" height="50" loading="lazy" />
                                        </td>
                                        <td><?php echo htmlspecialchars($productSale['product_name']); ?></td>
                                        <td><?php echo htmlspecialchars($productSale['total_units']); ?></td>
                                        <td><?php echo htmlspecialchars($productSale['unit_price']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                <div class="pagination">
                    <button id="prevPage">Previous</button>
                    <button id="nextPage">Next</button>
                </div>
        </div>
        
        <div class="grid-item grid-item-2">
            <!-- Potentially for more details or other reports -->
        </div>

        <div class="grid-item grid-item-3">
            <!-- Potentially for more details or other reports -->
        </div>
    


    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var salesData = <?php echo json_encode($salesData); ?>;
    var currentPage = 0;
    var itemsPerPage = 10;
    var searchKeyword = new URL(window.location.href).searchParams.get('productSearch');
    var filteredData = salesData; // Initialize with all data

    // Update the search input field if a search term exists
    if (searchKeyword) {
        document.getElementById('productSearch').value = searchKeyword;
        filteredData = salesData.filter(function(item) {
            return item.product_name.toLowerCase().includes(searchKeyword.toLowerCase());
        });
    }

    function renderTable() {
        var tableBody = document.querySelector('.scrollable-table-body-container table tbody');
        tableBody.innerHTML = ''; // Clear existing table content

        var startItem = currentPage * itemsPerPage;
        var endItem = startItem + itemsPerPage;
        var paginatedItems = filteredData.slice(startItem, endItem);

        paginatedItems.forEach(function(item) {
            var row = `<tr id="row-${item.product_id}">
                <td>${item.product_id}</td>
                <td><img src="data:image/jpeg;base64,${item.image}" height="50" loading="lazy" /></td>
                <td>${item.product_name}</td>
                <td>${item.total_units}</td>
                <td>${item.unit_price}</td>
            </tr>`;
            tableBody.innerHTML += row;
        });

        // Attach click event listeners to each row
        paginatedItems.forEach(function(item) {
            document.getElementById(`row-${item.product_id}`).addEventListener('click', function() {
                setSessionProductId(item.product_id);
            });
        });
    }

    renderTable(); // Render the initial table with filter if applicable

    // Attach event listeners for pagination
    document.getElementById('prevPage').addEventListener('click', function() {
        if (currentPage > 0) {
            currentPage--;
            renderTable();
        }
    });
    document.getElementById('nextPage').addEventListener('click', function() {
        var maxPage = Math.ceil(filteredData.length / itemsPerPage) - 1;
        if (currentPage < maxPage) {
            currentPage++;
            renderTable();
        }
    });

    // Filtering functionality
    document.getElementById('productSearch').addEventListener('input', function() {
        var inputKeyword = document.getElementById('productSearch').value.toLowerCase();
        filteredData = salesData.filter(function(item) {
            return item.product_name.toLowerCase().includes(inputKeyword);
        });
        currentPage = 0; // Reset to the first page
        renderTable();

        // Update the URL without reloading
        var currentUrl = new URL(window.location);
        currentUrl.searchParams.set('productSearch', inputKeyword);
        window.history.pushState({path:currentUrl.toString()}, '', currentUrl.toString());
    });
});

function setSessionProductId(productId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "set_session.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            console.log("Session set for product ID: " + productId);
            window.location.reload();
        }
    };
    xhr.send("productId=" + productId);
}
</script>



</body>
</html>




