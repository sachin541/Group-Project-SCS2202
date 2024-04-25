<?php
require_once 'database.php';

class Report {

    public function mergeAndSumSalesData($onlineData, $inStoreData) {
        $mergedData = [];
    
        // Add all online sales data to mergedData
        foreach ($onlineData as $data) {
            $saleDate = $data['sale_date'];
            if (!isset($mergedData[$saleDate])) {
                $mergedData[$saleDate] = [
                    'sale_date' => $saleDate,
                    'total_sales' => 0
                ];
            }
            $mergedData[$saleDate]['total_sales'] += $data['total_sales'];
        }
    
        // Add all in-store sales data to mergedData
        foreach ($inStoreData as $data) {
            $saleDate = $data['sale_date'];
            if (!isset($mergedData[$saleDate])) {
                $mergedData[$saleDate] = [
                    'sale_date' => $saleDate,
                    'total_sales' => 0
                ];
            }
            $mergedData[$saleDate]['total_sales'] += $data['total_sales'];
        }
    
        // Sort the merged data by sale date
        ksort($mergedData);
    
        // Optional: Convert the associative array back to an indexed array
        return array_values($mergedData);
    }


    public function mergeAndSumByGroup($onlineData, $inStoreData, $groupBy) {
        $mergedData = [];
    
        // Process online sales data
        foreach ($onlineData as $data) {
            $groupValue = $data[$groupBy];
            if (!isset($mergedData[$groupValue])) {
                $mergedData[$groupValue] = [
                    $groupBy => $groupValue,
                    'total_sales' => 0
                ];
            }
            $mergedData[$groupValue]['total_sales'] += $data['total_sales'];
        }
    
        // Process in-store sales data
        foreach ($inStoreData as $data) {
            $groupValue = $data[$groupBy];
            if (!isset($mergedData[$groupValue])) {
                $mergedData[$groupValue] = [
                    $groupBy => $groupValue,
                    'total_sales' => 0
                ];
            }
            $mergedData[$groupValue]['total_sales'] += $data['total_sales'];
        }
    
        // Convert associative array to indexed array
        return array_values($mergedData);
    }
    
}
class PieChart extends Report {
    private $db;
    private $colorPalette = [
        'rgb(236, 244, 214)', 'rgb(154, 208, 194)', 'rgb(45, 149, 150)',
        'rgb(38, 80, 115)', 'rgb(112, 128, 144)', 'rgb(188, 143, 143)',
        'rgb(47, 79, 79)', 'rgb(128, 0, 128)',
        'rgb(245, 255, 250)', 'rgb(216, 191, 216)'
    ];
    
    public function __construct($db) {
        $this->db = $db;
    }

    public function fetchSalesData($startDate, $endDate, $groupBy) {
        $groupByColumn = $groupBy;
    
        $query = "SELECT $groupByColumn, SUM(ip.quantity * p.price) AS total_sales 
                  FROM instorepurchase isp 
                  JOIN instorepurchase_items ip ON isp.order_id = ip.order_id 
                  JOIN products p ON ip.product_id = p.id 
                  WHERE isp.created_at BETWEEN ? AND ? 
                  GROUP BY $groupByColumn";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOnlineSalesData($startDate, $endDate, $groupBy, $paymentType = null) {
        
        $groupByColumn = $groupBy;

        $query = "SELECT $groupByColumn, SUM(oi.quantity * p.price) AS total_sales 
                  FROM orders o 
                  JOIN order_items oi ON o.order_id = oi.order_id 
                  JOIN products p ON oi.product_id = p.id 
                  WHERE o.payment_status = 'Payment Completed' 
                  AND o.created_at BETWEEN ? AND ? ";
    
        // Add condition for payment_type if it's specified
        if ($paymentType !== null) {
            $query .= "AND o.payment_type = ? ";
        }
    
        $query .= "GROUP BY $groupByColumn";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
    
        // Bind the paymentType parameter if provided
        if ($paymentType !== null) {
            $stmt->bindParam(3, $paymentType);
        }
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function processSalesData($rawData, $groupBy) {
        $brands = [];
        $sales = [];
        
        if($groupBy == "brand"){
            foreach ($rawData as $row) {
                $brands[] = $row['brand'];
                $sales[] = $row['total_sales'];
            }
        }else if($groupBy == "category"){
            foreach ($rawData as $row) {
                $brands[] = $row['category'];
                $sales[] = $row['total_sales'];
            }
        }else{
            return "error"; 
        }

        
    
        $dataWithLabels = [];
        foreach ($brands as $key => $brand) {
            $dataWithLabels[] = [
                'brand' => $brand,
                'total_sales' => $sales[$key],
            ];
        }
    
        usort($dataWithLabels, function ($a, $b) {
            return $b['total_sales'] - $a['total_sales'];
        });
    
        return $dataWithLabels;
    }

    public function generateChartData($processedData) {
        $brands = array_column($processedData, 'brand');
        $sales = array_column($processedData, 'total_sales');
    
        // $generatedColors = $this->generateColors(count($brands));
    
        return [
            'labels' => $brands,
            'datasets' => [[
                'data' => $sales,
                // 'backgroundColor' => $generatedColors,
                // 'hoverBackgroundColor' => $generatedColors,
                'borderWidth' => 0,
            ]]
        ];
    }

    public function getSalesDataForPieChart($startDate, $endDate, $groupBy, $Type) {
         
        if($Type == "ALL"){
            $OnlineData = $this->fetchOnlineSalesData($startDate, $endDate, $groupBy); 
            $InStoreData= $this->fetchSalesData($startDate, $endDate, $groupBy);
            $allData = $this->mergeAndSumByGroup($OnlineData, $InStoreData, $groupBy);;

        }else if($Type == "InStore"){
            $allData= $this->fetchSalesData($startDate, $endDate, $groupBy);
        }else if($Type == "PayOnlineAndDelivery"){
            $allData = $this->fetchOnlineSalesData($startDate, $endDate, $groupBy);
        }else if($Type == "PayOnlineONLY"){
            $allData = $this->fetchOnlineSalesData($startDate, $endDate, $groupBy, "pay_online");
        }else if($Type == "DeliveryONLY"){
            $allData = $this->fetchOnlineSalesData($startDate, $endDate, $groupBy, "pay_on_delivery");
        }else{
            return "error";
        }
        $processedData = $this->processSalesData($allData, $groupBy); // processSalesData needs the column names 
        return $this->generateChartData($processedData);

    }

}


class LineChart extends Report{
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function fetchSalesDataLineChart($startDate, $endDate) {
        $query = "SELECT DATE(isp.created_at) as sale_date, SUM(ip.quantity * p.price) AS total_sales 
                  FROM instorepurchase isp 
                  JOIN instorepurchase_items ip ON isp.order_id = ip.order_id 
                  JOIN products p ON ip.product_id = p.id 
                  WHERE isp.created_at BETWEEN ? AND ? 
                  GROUP BY sale_date";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function fetchOnlineSalesDataLineChart($startDate, $endDate, $paymentType = null) {
        $query = "SELECT DATE(o.created_at) as sale_date, SUM(oi.quantity * p.price) AS total_sales 
                  FROM orders o 
                  JOIN order_items oi ON o.order_id = oi.order_id 
                  JOIN products p ON oi.product_id = p.id 
                  WHERE o.payment_status = 'Payment Completed' 
                  AND o.created_at BETWEEN ? AND ? ";
    
        if ($paymentType !== null) {
            $query .= "AND o.payment_type = ? ";
        }
    
        $query .= "GROUP BY sale_date";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
    
        if ($paymentType !== null) {
            $stmt->bindParam(3, $paymentType);
        }
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function prepareLineChartData($salesData) {
        $labels = array();
        $dataPoints = array();
    
        foreach ($salesData as $row) {
            $labels[] = $row['sale_date'];
            $dataPoints[] = $row['total_sales'];
        }
    
        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Total Sales',
                    'data' => $dataPoints,
                    'backgroundColor' => 'rgba(0, 123, 255, 0.5)',
                    'borderColor' => 'rgba(0, 123, 255, 1)',
                    'borderWidth' => 1
                )
            )
        );
    }
    
    

    public function getSalesDataForLineChart($startDate, $endDate, $Type) {
        
        if ($Type == "ALL") {
            $OnlineData = $this->fetchOnlineSalesDataLineChart($startDate, $endDate);
            $InStoreData = $this->fetchSalesDataLineChart($startDate, $endDate);
            $allData = $this->mergeAndSumSalesData($OnlineData, $InStoreData); // Merge data from both sources

        } else if ($Type == "InStore") {
            $allData = $this->fetchSalesDataLineChart($startDate, $endDate);
        } else if ($Type == "PayOnlineAndDelivery") {
            $allData = $this->fetchOnlineSalesDataLineChart($startDate, $endDate);
        } else if ($Type == "PayOnlineONLY") {
            $allData = $this->fetchOnlineSalesDataLineChart($startDate, $endDate ,"pay_online");
        } else if ($Type == "DeliveryONLY") {
            $allData = $this->fetchOnlineSalesDataLineChart($startDate, $endDate, "pay_on_delivery");
        } else {
            return "error"; // Error handling for unsupported types
        }
    
        // Process and format the data for the line chart

        
        
        return $this->prepareLineChartData($allData);
    }
    
}

    
class ItemSales extends Report {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProductSalesFromRange($startDate, $endDate) {
        // Modified queries to include unit price and product image
        $onlineSalesQuery = "SELECT p.id as product_id, p.product_name, p.price as unit_price, p.image1, SUM(oi.quantity) as total_units 
                             FROM orders o
                             JOIN order_items oi ON o.order_id = oi.order_id
                             JOIN products p ON oi.product_id = p.id
                             WHERE o.created_at BETWEEN ? AND ?
                             GROUP BY p.id, p.product_name, p.price, p.image1";

        $inStoreSalesQuery = "SELECT p.id as product_id, p.product_name, p.price as unit_price, p.image1, SUM(ip.quantity) as total_units
                              FROM instorepurchase isp
                              JOIN instorepurchase_items ip ON isp.order_id = ip.order_id
                              JOIN products p ON ip.product_id = p.id
                              WHERE isp.created_at BETWEEN ? AND ?
                              GROUP BY p.id, p.product_name, p.price, p.image1";

        // Execute queries and fetch results
        $stmt = $this->db->prepare($onlineSalesQuery);
        $stmt->execute([$startDate, $endDate]);
        $onlineSales = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare($inStoreSalesQuery);
        $stmt->execute([$startDate, $endDate]);
        $inStoreSales = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Merge and process online and in-store sales data
        $mergedData = [];
        foreach (array_merge($onlineSales, $inStoreSales) as $sale) {
            $key = $sale['product_id'] . '_' . $sale['product_name'];
            if (!isset($mergedData[$key])) {
                $mergedData[$key] = [
                    'product_id' => $sale['product_id'], 
                    'product_name' => $sale['product_name'], 
                    'unit_price' => $sale['unit_price'], // Added unit price
                    'image' => base64_encode($sale['image1']), // Added product image, encoded for display
                    'total_units' => 0
                ];
            }
            $mergedData[$key]['total_units'] += $sale['total_units'];
        }

        // Sort the merged data by total units sold in descending order
        usort($mergedData, function ($a, $b) {
            return $b['total_units'] - $a['total_units'];
        });

        return $mergedData;
    }

    public function getDailySalesByProductId($startDate, $endDate, $productId) {
        // Query to get daily sales from online orders
        $onlineSalesQuery = "SELECT DATE(o.created_at) as sale_date, SUM(oi.quantity) as quantity_sold
                             FROM orders o
                             JOIN order_items oi ON o.order_id = oi.order_id
                             WHERE oi.product_id = ?
                             AND o.created_at BETWEEN ? AND ?
                             GROUP BY DATE(o.created_at)";
    
        // Query to get daily sales from in-store purchases
        $inStoreSalesQuery = "SELECT DATE(isp.created_at) as sale_date, SUM(ip.quantity) as quantity_sold
                              FROM instorepurchase isp
                              JOIN instorepurchase_items ip ON isp.order_id = ip.order_id
                              WHERE ip.product_id = ?
                              AND isp.created_at BETWEEN ? AND ?
                              GROUP BY DATE(isp.created_at)";
    
        // Execute online sales query and fetch results
        $stmt = $this->db->prepare($onlineSalesQuery);
        $stmt->execute([$productId, $startDate, $endDate]);
        $onlineSales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Execute in-store sales query and fetch results
        $stmt = $this->db->prepare($inStoreSalesQuery);
        $stmt->execute([$productId, $startDate, $endDate]);
        $inStoreSales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Merge and process sales data
        $salesData = array_merge($onlineSales, $inStoreSales);
        $dailySales = [];
        foreach ($salesData as $sale) {
            $saleDate = $sale['sale_date'];
            if (!isset($dailySales[$saleDate])) {
                $dailySales[$saleDate] = 0;
            }
            $dailySales[$saleDate] += $sale['quantity_sold'];
        }
    
        // Ensure every date in the range is represented, even if no sales occurred
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            new DateTime($endDate)
        );
    
        $completeSalesData = [];
        foreach ($period as $date) {
            $formattedDate = $date->format("Y-m-d");
            $completeSalesData[$formattedDate] = isset($dailySales[$formattedDate]) ? $dailySales[$formattedDate] : 0;
        }
    
        return $completeSalesData;
    }


    public function getDailyRevenueByProductId($startDate, $endDate, $productId) {
        // Query to get daily revenue from online orders
        $onlineRevenueQuery = "SELECT DATE(o.created_at) as sale_date, SUM(oi.quantity * p.price) as daily_revenue
                                FROM orders o
                                JOIN order_items oi ON o.order_id = oi.order_id
                                JOIN products p ON oi.product_id = p.id
                                WHERE oi.product_id = ?
                                AND o.created_at BETWEEN ? AND ?
                                GROUP BY DATE(o.created_at)";
    
        // Query to get daily revenue from in-store purchases
        $inStoreRevenueQuery = "SELECT DATE(isp.created_at) as sale_date, SUM(ip.quantity * p.price) as daily_revenue
                                FROM instorepurchase isp
                                JOIN instorepurchase_items ip ON isp.order_id = ip.order_id
                                JOIN products p ON ip.product_id = p.id
                                WHERE ip.product_id = ?
                                AND isp.created_at BETWEEN ? AND ?
                                GROUP BY DATE(isp.created_at)";
    
        // Execute online revenue query and fetch results
        $stmt = $this->db->prepare($onlineRevenueQuery);
        $stmt->execute([$productId, $startDate, $endDate]);
        $onlineRevenue = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Execute in-store revenue query and fetch results
        $stmt = $this->db->prepare($inStoreRevenueQuery);
        $stmt->execute([$productId, $startDate, $endDate]);
        $inStoreRevenue = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Merge and process revenue data
        $revenueData = array_merge($onlineRevenue, $inStoreRevenue);
        $dailyRevenue = [];
        foreach ($revenueData as $revenue) {
            $saleDate = $revenue['sale_date'];
            if (!isset($dailyRevenue[$saleDate])) {
                $dailyRevenue[$saleDate] = 0;
            }
            $dailyRevenue[$saleDate] += $revenue['daily_revenue'];
        }
    
        // Ensure every date in the range is represented, even if no revenue was generated
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            new DateTime($endDate)
        );
    
        $completeRevenueData = [];
        foreach ($period as $date) {
            $formattedDate = $date->format("Y-m-d");
            $completeRevenueData[$formattedDate] = isset($dailyRevenue[$formattedDate]) ? $dailyRevenue[$formattedDate] : 0;
        }
    
        return $completeRevenueData;
    }
    
    
}
 
    
class BuildReport extends Report{

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBuildRequestCountByDateRange($startDate, $endDate) {
        $query = "SELECT DATE(added_timestamp) as request_date, COUNT(*) as request_count 
                  FROM builds 
                  WHERE added_timestamp BETWEEN ? AND ? 
                  GROUP BY DATE(added_timestamp)
                  ORDER BY DATE(added_timestamp)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dailyCounts = [];

        // Initialize all dates in the range with a count of 0
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day') // Include end date in the period
        );

        foreach ($period as $date) {
            $formattedDate = $date->format("Y-m-d");
            $dailyCounts[$formattedDate] = 0; // Initialize with 0
        }

        // Populate the array with actual counts
        foreach ($results as $result) {
            if (array_key_exists($result['request_date'], $dailyCounts)) {
                $dailyCounts[$result['request_date']] = (int)$result['request_count'];
            }
        }

        return $dailyCounts;
    }

    public function getBuildsCompletedByDateRange($startDate, $endDate) {
        $query = "SELECT DATE(build_completed_date) as completed_date, COUNT(*) as completed_count
                  FROM builds
                  WHERE build_completed_date BETWEEN ? AND ?
                  GROUP BY DATE(build_completed_date)
                  ORDER BY DATE(build_completed_date)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dailyCompletedCounts = [];

        // Initialize all dates in the range with a count of 0 to ensure continuity
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day') // Include the end date
        );

        foreach ($period as $date) {
            $formattedDate = $date->format("Y-m-d");
            $dailyCompletedCounts[$formattedDate] = 0; // Initialize with 0
        }

        // Populate the array with actual counts
        foreach ($results as $result) {
            if (array_key_exists($result['completed_date'], $dailyCompletedCounts)) {
                $dailyCompletedCounts[$result['completed_date']] = (int)$result['completed_count'];
            }
        }

        return $dailyCompletedCounts;
    }

    public function getBuildsCompletedByTechnician($startDate, $endDate) {
        $query = "SELECT ld.id AS technicianID, e.staff_name AS technicianName, COUNT(*) AS completedBuilds
                  FROM builds b
                  INNER JOIN login_details ld ON b.technician_id = ld.id
                  INNER JOIN employees e ON ld.id = e.staff_id
                  WHERE b.build_completed_date BETWEEN ? AND ?
                  AND ld.role = 'technician' -- Assuming role column exists and technician role is identifiable
                  GROUP BY ld.id, e.staff_name
                  ORDER BY completedBuilds DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate, PDO::PARAM_STR);
        $stmt->bindParam(2, $endDate, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $buildsCompletedByTechnician = [];

        foreach ($results as $result) {
            $buildsCompletedByTechnician[$result['technicianID']] = [
                'name' => $result['technicianName'],
                'completedBuilds' => $result['completedBuilds']
            ];
        }

        return $buildsCompletedByTechnician;
    }


    public function getBuildCountsByStageAndDateRange($startDate, $endDate) {
        $query = "SELECT 
                    CASE 
                        WHEN rejected = 1 THEN 'Request Rejected'
                        WHEN technician_assigned_date IS NOT NULL AND build_start_date IS NULL THEN 'Technician Assigned'
                        WHEN build_start_date IS NOT NULL AND build_completed_date IS NULL THEN 'In Progress'
                        WHEN build_completed_date IS NOT NULL AND build_collected_date IS NULL THEN 'Collection Pending'
                        WHEN build_collected_date IS NOT NULL THEN 'Request Completed'
                        ELSE 'Request Created' 
                    END AS build_stage,
                    COUNT(*) AS stage_count
                  FROM builds
                  WHERE added_timestamp BETWEEN ? AND ?
                  GROUP BY build_stage
                  ORDER BY build_stage";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $buildsByStage = [];
    
        foreach ($results as $result) {
            $buildsByStage[$result['build_stage']] = $result['stage_count'];
        }
    
        return $buildsByStage;
    }

    public function getDailyProfitFromBuilds($startDate, $endDate) {
        $query = "SELECT DATE(build_completed_date) as completed_date, 
                         SUM(amount) as daily_profit
                  FROM builds
                  WHERE build_completed_date BETWEEN ? AND ?
                  GROUP BY DATE(build_completed_date)
                  ORDER BY DATE(build_completed_date)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare the array to store daily profit data formatted for Chart.js
        $formattedData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => "Daily Sales",
                    'data' => [],
                    'backgroundColor' => "rgba(75, 192, 192, 0.2)",
                    'borderColor' => "rgba(75, 192, 192, 1)",
                    'fill' => false
                ]
            ]
        ];

        // Generate a DatePeriod from startDate to endDate + 1 day
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day')
        );

        // Initialize all dates in the period with a profit of 0
        foreach ($period as $date) {
            $formattedDate = $date->format("Y-m-d");
            $formattedData['labels'][] = $formattedDate;
            $formattedData['datasets'][0]['data'][] = 0;  // Initialize profits as 0
        }

        // Map database results to the appropriate dates
        foreach ($results as $result) {
            $dateKey = array_search($result['completed_date'], $formattedData['labels']);
            if ($dateKey !== false) {
                $formattedData['datasets'][0]['data'][$dateKey] = (float)$result['daily_profit'];
            }
        }

        return $formattedData;
    }


    public function getDailyProfitFromRepair($startDate, $endDate) {
        $query = "SELECT DATE(item_collected_date) as completed_date, 
                         SUM(amount) as daily_profit
                  FROM repairs
                  WHERE item_collected_date BETWEEN ? AND ?
                  GROUP BY DATE(item_collected_date)
                  ORDER BY DATE(item_collected_date)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare the array to store daily profit data formatted for Chart.js
        $formattedData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => "Daily Sales",
                    'data' => [],
                    'backgroundColor' => "rgba(75, 192, 192, 0.2)",
                    'borderColor' => "rgba(75, 192, 192, 1)",
                    'fill' => false
                ]
            ]
        ];

        // Generate a DatePeriod from startDate to endDate + 1 day
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day')
        );

        // Initialize all dates in the period with a profit of 0
        foreach ($period as $date) {
            $formattedDate = $date->format("Y-m-d");
            $formattedData['labels'][] = $formattedDate;
            $formattedData['datasets'][0]['data'][] = 0;  // Initialize profits as 0
        }

        // Map database results to the appropriate dates
        foreach ($results as $result) {
            $dateKey = array_search($result['completed_date'], $formattedData['labels']);
            if ($dateKey !== false) {
                $formattedData['datasets'][0]['data'][$dateKey] = (float)$result['daily_profit'];
            }
        }

        return $formattedData;
    }
    
    
    
}

class RepairReport extends Report {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getRepairRequestCountByDateRange($startDate, $endDate) {
        $query = "SELECT DATE(added_timestamp) as request_date, COUNT(*) as request_count
                  FROM repairs
                  WHERE added_timestamp BETWEEN ? AND ?
                  GROUP BY DATE(added_timestamp)
                  ORDER BY DATE(added_timestamp)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dailyCounts = [];

        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day')
        );

        foreach ($period as $date) {
            $formattedDate = $date->format("Y-m-d");
            $dailyCounts[$formattedDate] = 0; // Initialize with 0
        }

        foreach ($results as $result) {
            if (array_key_exists($result['request_date'], $dailyCounts)) {
                $dailyCounts[$result['request_date']] = (int)$result['request_count'];
            }
        }

        return $dailyCounts;
    }

    public function getRepairsCompletedByDateRange($startDate, $endDate) {
        $query = "SELECT DATE(repair_completed_date) as completed_date, COUNT(*) as completed_count
                  FROM repairs
                  WHERE repair_completed_date BETWEEN ? AND ?
                  GROUP BY DATE(repair_completed_date)
                  ORDER BY DATE(repair_completed_date)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dailyCompletedCounts = [];

        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day')
        );

        foreach ($period as $date) {
            $formattedDate = $date->format("Y-m-d");
            $dailyCompletedCounts[$formattedDate] = 0;
        }

        foreach ($results as $result) {
            if (array_key_exists($result['completed_date'], $dailyCompletedCounts)) {
                $dailyCompletedCounts[$result['completed_date']] = (int)$result['completed_count'];
            }
        }

        return $dailyCompletedCounts;
    }

    public function getRepairsCompletedByTechnician($startDate, $endDate) {
        $query = "SELECT ld.id AS technicianID, e.staff_name AS technicianName, COUNT(*) AS completedRepairs
                  FROM repairs r
                  INNER JOIN login_details ld ON r.technician_id = ld.id
                  INNER JOIN employees e ON ld.id = e.staff_id
                  WHERE r.item_collected_date BETWEEN ? AND ?
                  AND ld.role = 'technician'
                  GROUP BY ld.id, e.staff_name
                  ORDER BY completedRepairs DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate, PDO::PARAM_STR);
        $stmt->bindParam(2, $endDate, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $repairsCompletedByTechnician = [];

        foreach ($results as $result) {
            $repairsCompletedByTechnician[$result['technicianID']] = [
                'name' => $result['technicianName'],
                'completedRepairs' => $result['completedRepairs']
            ];
        }

        return $repairsCompletedByTechnician;
    }

    public function getRepairCountsByStageAndDateRange($startDate, $endDate) {
        $query = "SELECT 
                    CASE 
                        WHEN rejected = 1 THEN 'Repair Rejected'
                        WHEN technician_assigned_date IS NOT NULL AND repair_wip_date IS NULL THEN 'Technician Assigned'
                        WHEN repair_wip_date IS NOT NULL AND repair_completed_date IS NULL THEN 'In Progress'
                        WHEN repair_completed_date IS NOT NULL AND item_collected_date IS NULL THEN 'Collection Pending'
                        WHEN item_collected_date IS NOT NULL THEN 'Repair Completed'
                        ELSE 'Request Created' 
                    END AS repair_stage,
                    COUNT(*) AS stage_count
                  FROM repairs
                  WHERE added_timestamp BETWEEN ? AND ?
                  GROUP BY repair_stage
                  ORDER BY repair_stage";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $repairsByStage = [];

        foreach ($results as $result) {
            $repairsByStage[$result['repair_stage']] = $result['stage_count'];
        }

        return $repairsByStage;
    }
}
