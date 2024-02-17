<?php
require_once '../classes/database.php';
require_once '../classes/reports.php';

$database = new Database();
$db = $database->getConnection();
$report = new ItemSales($db);

// Calculate the start date as 6 months back from today
$defaultStartDate = date('Y-m-d', strtotime('-2 months'));
$defaultEndDate = date('Y-m-d'); // Current date as the default end date

// Check if the dates are set in the GET parameters; otherwise, use calculated default dates
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : $defaultStartDate;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : $defaultEndDate;

// Retrieve the search term from URL parameters if available
$searchTerm = isset($_GET['productSearch']) ? $_GET['productSearch'] : '';

// Fetch the sales data, modified to potentially include search term filtering
$salesData = $report->getProductSalesFromRange($startDate . " 00:00:00", $endDate . " 23:59:59", $searchTerm);

$selectedProductId = isset($_SESSION['selectedProductId']) ? $_SESSION['selectedProductId'] : null;
$salesDataByItem = $report->getDailySalesByProductId($startDate . " 00:00:00", $endDate . " 23:59:59", $selectedProductId);
$salesRevenueByItem = $report->getDailyRevenueByProductId($startDate . " 00:00:00", $endDate . " 23:59:59", $selectedProductId);
?>


<!-- Template Top -->
<?php require_once '../templates/main_top.php'; ?>

<!-- Stylesheets -->
<link rel="stylesheet" href="../../resources/css/css_manager/reportsSideBar.css">
<link rel="stylesheet" href="../../resources/css/css_manager/reportsItemSales.css">

</head>

<body>

    <!-- Header -->
    <?php require_once '../templates/main_header.php'; ?>

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
                        <input type="hidden" name="page"
                            value="<?php echo isset($_GET['page']) ? $_GET['page'] : 0; ?>">

                        <input type="submit" value="Filter">
                    </form>
                </div>

                <div class="search-section">
                    <label for="productSearch">Search Product:</label>
                    <input type="text" id="productSearch" placeholder="Enter product name"
                        value="<?php echo htmlspecialchars($searchTerm); ?>">
                </div>

                <div class="product-table">
                    <h2>Product Sales Report (
                        <?php echo $startDate; ?> to
                        <?php echo $endDate; ?>)
                    </h2>

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
                                            <td>
                                                <?php echo htmlspecialchars($productSale['product_id']); ?>
                                            </td>
                                            <td>
                                                <img src="data:image/jpeg;base64,<?php echo base64_encode($productSale['image']); ?>"
                                                    height="50" />
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($productSale['product_name']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($productSale['total_units']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($productSale['unit_price']); ?>
                                            </td>
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
                SELECTED ITEM
                <?php echo $_SESSION['selectedProductId']; ?>
                <!-- Potentially for more details or other reports -->
                <div class="chart-container" style="width:100%;">
                    <canvas id="salesChart"></canvas>
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
        document.addEventListener('DOMContentLoaded', function () {
            var salesData = <?php echo json_encode($salesData); ?>;
            var urlParams = new URLSearchParams(window.location.search);
            var pageFromUrl = urlParams.get('page');
            currentPage = pageFromUrl ? parseInt(pageFromUrl) : 0;
            var itemsPerPage = 7;
            var searchKeyword = new URL(window.location.href).searchParams.get('productSearch');
            var filteredData = salesData; // Initialize with all data
            var selectedProductId = "<?php echo $selectedProductId; ?>";
            // Update the search input field if a search term exists
            if (searchKeyword) {
                document.getElementById('productSearch').value = searchKeyword;
                filteredData = salesData.filter(function (item) {
                    return item.product_name.toLowerCase().includes(searchKeyword.toLowerCase());
                });
            }

            function renderTable() {
                var tableBody = document.querySelector('.scrollable-table-body-container table tbody');
                tableBody.innerHTML = ''; // Clear existing table content

                var startItem = currentPage * itemsPerPage;
                var endItem = startItem + itemsPerPage;
                var paginatedItems = filteredData.slice(startItem, endItem);

                paginatedItems.forEach(function (item) {
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
                paginatedItems.forEach(function (item) {
                    document.getElementById(`row-${item.product_id}`).addEventListener('click', function () {
                        setSessionProductId(item.product_id);
                    });
                });
            }

            renderTable(); // Render the initial table with filter if applicable

            // Attach event listeners for pagination
            document.getElementById('prevPage').addEventListener('click', function () {
                if (currentPage > 0) {
                    currentPage--;
                    updatePageInUrl(currentPage);
                    renderTable();
                }
            });

            document.getElementById('nextPage').addEventListener('click', function () {
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
                window.history.pushState({ path: currentUrl.toString() }, '', currentUrl.toString());
            }



            // Filtering functionality
            document.getElementById('productSearch').addEventListener('input', function () {
                // Reset the currentPage to 0 for a new search
                currentPage = 0;

                // Extract the search keyword from the input
                var inputKeyword = this.value.toLowerCase();

                // Filter your dataset based on the new search keyword
                filteredData = salesData.filter(function (item) {
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
                window.history.pushState({ path: currentUrl.toString() }, '', currentUrl.toString());
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
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if ($selectedProductId && !empty($salesRevenueByItem)): ?>
                // Assuming $salesDataByItem now contains daily revenue data
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
                            pointRadius: revenueData.map(value => value === 0 ? 1 : 2), // Smaller radius for 0 values
                            pointHoverRadius: revenueData.map(value => value === 0 ? 3 : 7),
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Daily Revenue for Product ID: <?php echo $selectedProductId; ?>'
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
                                    labelString: 'Revenue ($)'
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
    </script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Footer -->
    <?php require_once '../templates/main_footer.php'; ?>

    <!-- Template Bottom -->
    <?php require_once '../templates/main_bottom.php'; ?>