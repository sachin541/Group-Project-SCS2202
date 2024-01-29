<?php
require_once 'database.php';
class Report {

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

    // public function getSalesByBrand($startDate, $endDate) {
    //     try {
    //         // Database query to fetch sales data
    //         $query = "SELECT p.brand, SUM(ip.quantity * p.price) AS total_sales 
    //                   FROM InStorePurchase isp 
    //                   JOIN InStorePurchase_Items ip ON isp.order_id = ip.order_id 
    //                   JOIN Products p ON ip.product_id = p.id 
    //                   WHERE isp.created_at BETWEEN ? AND ? 
    //                   GROUP BY p.brand";
    //         $stmt = $this->db->prepare($query);
    //         $stmt->bindParam(1, $startDate);
    //         $stmt->bindParam(2, $endDate);
    //         $stmt->execute();
    
    //         $brands = [];
    //         $sales = [];
    
    //         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //             $brands[] = $row['brand'];
    //             $sales[] = $row['total_sales'];
    //         }
    
    //         // Create an array to store the data and labels
    //         $dataWithLabels = [];
    
    //         foreach ($brands as $key => $brand) {
    //             $dataWithLabels[] = [
    //                 'brand' => $brand,
    //                 'total_sales' => $sales[$key],
    //             ];
    //         }
    
    //         // Sort the data by total sales (area taken) in descending order
    //         usort($dataWithLabels, function ($a, $b) {
    //             return $b['total_sales'] - $a['total_sales'];
    //         });
    
    //         // Extract the sorted labels and sales data
    //         $brands = array_column($dataWithLabels, 'brand');
    //         $sales = array_column($dataWithLabels, 'total_sales');
    
    //         // Generate colors based on the number of brands
    //         $generatedColors = $this->generateColors(count($brands));
    
    //         return [
    //             'labels' => $brands,
    //             'datasets' => [[
    //                 'data' => $sales,
    //                 'backgroundColor' => $generatedColors,
    //                 'hoverBackgroundColor' => $generatedColors,
    //                 'borderWidth' => 0,
    //             ]]
    //         ];
    //     } catch (PDOException $e) {
    //         throw $e;
    //     }
    // }

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


        }else if($Type == "InStore"){
            $allData= $this->fetchSalesData($startDate, $endDate, $groupBy);
        }else if($Type == "PayOnlineAndDelviery"){
            $allData = $this->fetchOnlineSalesData($startDate, $endDate, $groupBy);
        }else if($Type == "PayOnineONLY"){
            $allData = $this->fetchOnlineSalesData($startDate, $endDate, $groupBy, "pay_online");
        }else if($Type == "DeliveryONLY"){
            $allData = $this->fetchOnlineSalesData($startDate, $endDate, $groupBy, "pay_on_delive");
        }else{
            return "error";
        }
        $processedData = $this->processSalesData($allData, $groupBy); // processSalesData needs the column names 
        return $this->generateChartData($processedData);

    }


    
    
    
    

}
