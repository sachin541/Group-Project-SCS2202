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

    public function generateColors($numColors, $mainColors) {
        $generatedColors = [];
        $colorVariation = 20; // Adjust this value for more or less variation
    
        foreach ($mainColors as $color) {
            // Convert the RGB color to an array
            preg_match("/rgb\((\d+),\s*(\d+),\s*(\d+)\)/", $color, $matches);
            $r = (int)$matches[1];
            $g = (int)$matches[2];
            $b = (int)$matches[3];
    
            // Generate variations
            for ($i = 0; $i < ceil($numColors / count($mainColors)); $i++) {
                $newR = max(0, min(255, $r + rand(-$colorVariation, $colorVariation)));
                $newG = max(0, min(255, $g + rand(-$colorVariation, $colorVariation)));
                $newB = max(0, min(255, $b + rand(-$colorVariation, $colorVariation)));
                $generatedColors[] = "rgb($newR, $newG, $newB)";
            }
        }
    
        // Return only the number of colors needed
        return array_slice($generatedColors, 0, $numColors);
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
    
            // Main color palette
            $mainColors = [
                'rgb(0, 128, 128)',   // Teal color
                'rgb(0, 139, 139)',   // Dark Cyan
                'rgb(127, 255, 212)', // Aquamarine
                'rgb(95, 158, 160)',  // Cadet Blue
                'rgb(224, 255, 255)', // Light Cyan
                'rgb(72, 209, 204)'   // Medium Turquoise
            ];
            
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $brands[] = $row['brand'];
                $sales[] = $row['total_sales'];
            }
    
            // Generate colors based on the number of brands
            $backgroundColor = $this->generateColors(count($brands), $mainColors);
            $hoverBackgroundColor = $backgroundColor; // You can choose to make this the same or different
    
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