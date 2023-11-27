<?php
require_once 'database.php';
require_once 'users.php';
class Product {
    
    private $db; 

    public function __construct($db) {
        $this->db = $db;
    }

    public function addProduct($productName, $category, $quantity, $description, $price, $discount, $brand, $image1, $image2, $image3) {
        try {
            $query = "INSERT INTO products (product_name, category, quantity, product_description, price, discount, brand, image1, image2, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(1, $productName);
            $stmt->bindParam(2, $category);
            $stmt->bindParam(3, $quantity);
            $stmt->bindParam(4, $description);
            $stmt->bindParam(5, $price);
            $stmt->bindParam(6, $discount);
            $stmt->bindParam(7, $brand);
            $stmt->bindParam(8, $image1, PDO::PARAM_LOB);
            $stmt->bindParam(9, $image2, PDO::PARAM_LOB);
            $stmt->bindParam(10, $image3, PDO::PARAM_LOB);

            $stmt->execute();
            return $this->db->lastInsertId();
        } catch(PDOException $e) {
            throw $e;
        }
    }


    public function getProductsByCategory($categoryName) {
        try {
            $query = "SELECT * FROM products WHERE category = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $categoryName);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw $e;
        }
    }
    



















}
?>
