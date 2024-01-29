<?php
require_once 'database.php';
class LineChart {
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

    function prepareChartData($salesData) {
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
        
        // if ($Type == "ALL") {
        //     $OnlineData = $this->fetchOnlineSalesDataLineChart($startDate, $endDate);
        //     $InStoreData = $this->fetchSalesDataLineChart($startDate, $endDate);
        //     $allData = array_merge($OnlineData, $InStoreData); // Merge data from both sources
        // } else if ($Type == "InStore") {
        //     $allData = $this->fetchSalesDataLineChart($startDate, $endDate);
        // } else if ($Type == "PayOnlineAndDelivery") {
        //     $allData = $this->fetchOnlineSalesDataLineChart($startDate, $endDate, "date");
        // } else if ($Type == "PayOnlineONLY") {
        //     $allData = $this->fetchOnlineSalesDataLineChart($startDate, $endDate ,"pay_online");
        // } else if ($Type == "DeliveryONLY") {
        //     $allData = $this->fetchOnlineSalesDataLineChart($startDate, $endDate, "pay_on_delive");
        // } else {
        //     return "error"; // Error handling for unsupported types
        // }
    
        // // Process and format the data for the line chart

        $data = $this->fetchSalesDataLineChart($startDate, $endDate); 
        
        return $this->prepareChartData($data);
    }
    
    
    





}