<?php
require_once 'database.php';

class Report {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function getUniqueBrands() {
        try {
            // Fetch all unique categories from the database
            $query = "SELECT DISTINCT brand FROM products";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $brand = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

            // Return the unique categories
            return $brand;
        } catch(PDOException $e) {
            throw $e;
        }
    }


    public function getUniqueCategories() {
        try {
            // Fetch all unique categories from the database
            $query = "SELECT DISTINCT category FROM products";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

            // Return the unique categories
            return $categories;
        } catch(PDOException $e) {
            throw $e;
        }
    }
    
    public function getSalesByBrand($startDate, $endDate) {
            try {
                $query = "SELECT p.brand, SUM(ip.quantity * p.price) AS total_sales 
                          FROM InStorePurchase isp 
                          JOIN InStorePurchase_Items ip ON isp.order_id = ip.order_id 
                          JOIN Products p ON ip.product_id = p.id 
                          WHERE isp.created_at BETWEEN ? AND ? 
                          GROUP BY p.brand";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(1, $startDate);
                $stmt->bindParam(2, $endDate);
                $stmt->execute();
    
                $brands = [];
                $sales = [];
                $backgroundColor = ['#FF6384', '#36A2EB', '#FFCE56']; // You can add more colors if needed
                $hoverBackgroundColor = $backgroundColor; // Same as background color for simplicity
    
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $brands[] = $row['brand'];
                    $sales[] = $row['total_sales'];
                }
    
                return [
                    'labels' => $brands,
                    'datasets' => [[
                        'data' => $sales,
                        'backgroundColor' => $backgroundColor,
                        'hoverBackgroundColor' => $hoverBackgroundColor
                    ]]
                ];
            } catch(PDOException $e) {
                throw $e;
            }
        }
    
    









}