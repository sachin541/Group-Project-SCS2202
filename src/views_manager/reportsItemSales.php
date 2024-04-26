<?php
require_once '../classes/database.php';
require_once '../classes/reports.php';
require_once '../components/headers/main_header.php';
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'manager' )){
    header('Location: ../views_main/denied.php');
    exit;
}
$database = new Database();
$db = $database->getConnection();
$report = new ItemSales($db);

// Calculate the start date as 6 months back from today
$defaultStartDate = date('Y-m-d', strtotime('-1 months'));
$defaultEndDate = date('Y-m-d'); // Current date as the default end date

// Check if the dates are set in the GET parameters; otherwise, use calculated default dates
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : $defaultStartDate;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : $defaultEndDate;

// Retrieve the search term from URL parameters if available
$searchTerm = isset($_GET['productSearch']) ? $_GET['productSearch'] : '';

// Fetch the sales data, modified to potentially include search term filtering
$salesData = $report->getProductSalesFromRange($startDate . " 00:00:00", $endDate . " 23:59:59");


if (!empty($salesData)) {
    // Set $_SESSION['selectedProductId'] to the first item's product_id if not already set or if $salesData is not empty
    $_SESSION['selectedProductId'] = isset($_SESSION['selectedProductId']) ? $_SESSION['selectedProductId'] : $salesData[0]['product_id'];
}

$selectedProductId = isset($_SESSION['selectedProductId']) ? $_SESSION['selectedProductId'] :  null;
$salesDataByItem = $report->getDailySalesByProductId($startDate . " 00:00:00", $endDate . " 23:59:59", $selectedProductId);
$salesRevenueByItem = $report->getDailyRevenueByProductId($startDate . " 00:00:00", $endDate . " 23:59:59", $selectedProductId);
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

                    <!-- Existing hidden input for preserving the search term -->
                    <input type="hidden" name="productSearch" value="<?php echo htmlspecialchars($searchTerm); ?>">

                    <!-- Additional hidden input for preserving the current page -->
                    <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? $_GET['page'] : 0; ?>">

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
                                <th>ID</th>
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
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($productSale['image']); ?>" height="50"  />
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
           <!-- Data for Item ID <?php echo $_SESSION['selectedProductId'];?> -->
            <!-- Potentially for more details or other reports -->
            <div class="chart-container" style="width:100%;">
                <canvas id="salesChart" ></canvas>
            </div>

        </div>

        <div class="grid-item grid-item-3">
            <div class="chart-container" style="width:100%;">
                <canvas id="revenueChart"></canvas>
            </div>

        </div>
    


    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var salesData = <?php echo json_encode($salesData); ?>;
    var urlParams = new URLSearchParams(window.location.search);
    var pageFromUrl = urlParams.get('page');
    currentPage = pageFromUrl ? parseInt(pageFromUrl) : 0;
    var itemsPerPage = 6;
    var searchKeyword = new URL(window.location.href).searchParams.get('productSearch');
    var filteredData = salesData; // Initialize with all data
    var selectedProductId = "<?php echo $selectedProductId; ?>";
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
            var isSelected = item.product_id == selectedProductId ? 'selected-item' : '';
            var row = `<tr id="row-${item.product_id}" class="${isSelected}">
                <td>${item.product_id}</td>
                <td><img src="data:image/jpeg;base64,${item.image}" height="50"  /></td>
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
        updatePageInUrl(currentPage);
        renderTable();
    }
    });

    document.getElementById('nextPage').addEventListener('click', function() {
        var maxPage = Math.ceil(filteredData.length / itemsPerPage) - 1;
        if (currentPage < maxPage) {
            currentPage++;
            updatePageInUrl(currentPage);
            renderTable();
        }
    });

    function updatePageInUrl(currentPage) {
    var currentUrl = new URL(window.location);
    currentUrl.searchParams.set('page', currentPage);
    window.history.pushState({path:currentUrl.toString()}, '', currentUrl.toString());
    }



    // Filtering functionality
    document.getElementById('productSearch').addEventListener('input', function() {
    // Reset the currentPage to 0 for a new search
    currentPage = 0;

    // Extract the search keyword from the input
    var inputKeyword = this.value.toLowerCase();

    // Filter your dataset based on the new search keyword
    filteredData = salesData.filter(function(item) {
        return item.product_name.toLowerCase().includes(inputKeyword);
    });

    // Update the page in the URL query parameters to 0
    updatePageInUrl(currentPage);

    // Rerender the table with the filtered data starting from the first page
    renderTable();

    // Update the URL without reloading to include the new search term and reset page number
    var currentUrl = new URL(window.location);
    currentUrl.searchParams.set('productSearch', inputKeyword);
    currentUrl.searchParams.set('page', currentPage); // Reflect the reset page number in the URL
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($selectedProductId && !empty($salesDataByItem)): ?>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesData = <?php echo json_encode(array_values($salesDataByItem)); ?>;
    var salesLabels = <?php echo json_encode(array_keys($salesDataByItem)); ?>;
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Sales Volume',
                data: salesData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Light green/blue
                borderColor: 'rgba(75, 192, 192, 1)', // Darker green/blue
                borderWidth: 1,
                 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: 'black' // Label color
                    }
                },
                title: {
                    display: true,
                    text: 'Item Sales for Product ID: <?php echo $selectedProductId; ?>',
                    font: {
                        size: 20
                    },
                    
                    padding: {
                        top: 10,
                        bottom: 30
                    }
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
                        color: '#000', // Change the color of text to black for better readability
                    },
                    grid: {
                        display: false // Hide grid lines on x-axis to enhance clarity
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0, // Avoid decimal values in y-axis ticks
                        color: '#000' // Change the color of text to black for better readability
                    },
                    grid: {
                        
                    }
                }
            }
        }
    });
    <?php endif; ?>
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($selectedProductId && !empty($salesRevenueByItem)): ?>
    var ctxRevenue = document.getElementById('revenueChart').getContext('2d'); // Ensure you have a canvas with id="revenueChart"
    var revenueData = <?php echo json_encode(array_values($salesRevenueByItem)); ?>;
    var revenueLabels = <?php echo json_encode(array_keys($salesRevenueByItem)); ?>;

    var revenueChart = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Daily Revenue',
                data: revenueData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)', // Light red background
                borderColor: 'rgba(255, 99, 132, 1)', // Darker red border
                borderWidth: 1,
                fill: false,
                pointRadius: revenueData.map(value => value === 0 ? 1 : 3), // Conditional radius based on value
                pointHoverRadius: revenueData.map(value => value === 0 ? 3 : 6), // Larger on hover
                lineTension: 0.4 // Slightly smooths lines for better visual appeal
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: 'black' // consistent with the bar chart
                    }
                },
                title: {
                    display: true,
                    text: 'Daily Revenue for Product ID: <?php echo $selectedProductId; ?>',
                    font: {
                        size: 20
                    },
                    
                    padding: {
                        top: 10,
                        bottom: 30
                    }
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
    <?php endif; ?>
});
</script>




</body>
</html>




