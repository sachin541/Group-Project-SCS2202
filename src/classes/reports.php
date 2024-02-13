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

    public function generateColors($numColors) {
        $totalColors = count($this->colorPalette);
        $selectedColors = [];

        for ($i = 0; $i < $numColors; $i++) {
            // Select colors deterministically from the color palette
            $colorIndex = $i % $totalColors;
            $selectedColors[] = $this->colorPalette[$colorIndex];
        }

        return $selectedColors;
    }

    public function fetchSalesData($startDate, $endDate, $groupBy) {
        $groupByColumn = $groupBy;
    
        $query = "SELECT $groupByColumn, SUM(ip.quantity * p.price) AS total_sales 
                  FROM InStorePurchase isp 
                  JOIN InStorePurchase_Items ip ON isp.order_id = ip.order_id 
                  JOIN Products p ON ip.product_id = p.id 
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
                  FROM Orders o 
                  JOIN Order_Items oi ON o.order_id = oi.order_id 
                  JOIN Products p ON oi.product_id = p.id 
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
    
        $generatedColors = $this->generateColors(count($brands));
    
        return [
            'labels' => $brands,
            'datasets' => [[
                'data' => $sales,
                'backgroundColor' => $generatedColors,
                'hoverBackgroundColor' => $generatedColors,
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
                  FROM InStorePurchase isp 
                  JOIN InStorePurchase_Items ip ON isp.order_id = ip.order_id 
                  JOIN Products p ON ip.product_id = p.id 
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
                  FROM Orders o 
                  JOIN Order_Items oi ON o.order_id = oi.order_id 
                  JOIN Products p ON oi.product_id = p.id 
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


class ItemSales extends Report{
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getProductSalesFromRange($startDate, $endDate) {
        // Include times in your date strings if not already (e.g., '2024-02-10 00:00:00' and '2024-02-15 23:59:59')
        $onlineSalesQuery = "SELECT p.id as product_id, p.product_name, SUM(oi.quantity) as total_units
                             FROM Orders o
                             JOIN Order_Items oi ON o.order_id = oi.order_id
                             JOIN Products p ON oi.product_id = p.id
                             WHERE o.created_at BETWEEN ? AND ?
                             GROUP BY p.id, p.product_name";

        $inStoreSalesQuery = "SELECT p.id as product_id, p.product_name, SUM(ip.quantity) as total_units
                              FROM InStorePurchase isp
                              JOIN InStorePurchase_Items ip ON isp.order_id = ip.order_id
                              JOIN Products p ON ip.product_id = p.id
                              WHERE isp.created_at BETWEEN ? AND ?
                              GROUP BY p.id, p.product_name";

        $stmt = $this->db->prepare($onlineSalesQuery);
        $stmt->execute([$startDate, $endDate]);
        $onlineSales = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare($inStoreSalesQuery);
        $stmt->execute([$startDate, $endDate]);
        $inStoreSales = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $mergedData = [];
        foreach (array_merge($onlineSales, $inStoreSales) as $sale) {
            $key = $sale['product_id'] . '_' . $sale['product_name'];
            if (!isset($mergedData[$key])) {
                $mergedData[$key] = ['product_id' => $sale['product_id'], 'product_name' => $sale['product_name'], 'total_units' => 0];
            }
            $mergedData[$key]['total_units'] += $sale['total_units'];
        }

        // Sort the merged data by total units sold in descending order
        usort($mergedData, function ($a, $b) {
            return $b['total_units'] - $a['total_units'];
        });

        return $mergedData;
    }




}